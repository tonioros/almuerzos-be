<?php

namespace App\Jobs;

use App\Constants\OrderState;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class CookingAnOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Order $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get Recipe Ingredients for the Recipe selected in the order
     * and Go to Warehouse to check if the ingredients are available
     * then call ingredients-to-use to spend change total available
     * on the warehouse.
     * Then await to complete the order preparation and notify to client
     * that order is ready
     */
    public function handle(): void
    {
        $warehouseURL = env('WAREHOUSE_URL');
        $ingredientsList = $this->order->recipe->ingredients;
        $ingredientsToUse = $ingredientsList->reduce(function ($prevVal, $ingredient) {
            return ($prevVal) . "," . $ingredient->ingredient . ":" . $ingredient->total_to_use;
        });
        $ingredientsToUse = substr($ingredientsToUse, 1, strlen($ingredientsToUse) - 1);
        $haveIngredients = Http::get($warehouseURL . '/ingredients/' . $ingredientsToUse)->ok();
        if ($haveIngredients) {
            $ingredientsToUseObj = [];
            $ingredientsList->each(function ($item) use (&$ingredientsToUseObj) {
                $ingredientsToUseObj[$item->ingredient] = $item->total_to_use;
            });
            Http::post($warehouseURL . '/ingredients-to-use', $ingredientsToUseObj)->ok();
            $this->order->status = OrderState::COOKING;
            $this->order->save();
            // for this emulation, I'm using aprox preparation time to add a realistic to states changes
            sleep($this->order->recipe->avg_preparation_time);
            $this->order->status = OrderState::COMPLETED;
            $this->order->delivery_date = Carbon::now()->toDateTimeString();
            $this->order->save();
            $this->sendPushNotification($this->order);
        } else {
            error_log("Failed call to: " . $warehouseURL . '/ingredients/' . $ingredientsToUse);
            $this->order->status = OrderState::WITHOUT_INGREDIENTS;
            $this->order->save();
        }
    }

    /**
     * Send Push Notification to Firebase Server
     * that to send a notification on the user device
     *
     * @param Order $order
     * @return void
     * @throws \Kreait\Firebase\Exception\FirebaseException
     * @throws \Kreait\Firebase\Exception\MessagingException
     */
    private function sendPushNotification(Order $order)
    {
        $messaging = Firebase::messaging();
        $message = CloudMessage::fromArray([
            'token' => $order->fcm_token,
            'notification' => [
                'title' => "Tu almuerzo esta listo",
                'body' => "Tu " . $order->recipe->name . " esta listo, puedes pasar a traerlo",
            ],
            'data' => [
                'order' => $order,
            ]
        ]);
        $messaging->send($message);

    }
}
