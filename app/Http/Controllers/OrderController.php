<?php

namespace App\Http\Controllers;

use App\Constants\OrderState;
use App\Jobs\CookingAnOrderJob;
use App\Models\Order;
use App\Models\Recipe;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function startANewOrder(Request $request)
    {
        $isValidData = $request->validate([
            "fcm_token" => 'required|string',
            "request_date" => 'required',
        ]);

        if ($isValidData) {
            $orderData = $request->all();
            $orderData['recipe_id'] = Recipe::all()->random()->id;
            $orderData['status'] = OrderState::PENDING;
            $order = Order::create($orderData);
            dispatch(new CookingAnOrderJob($order));
            return $order;
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Order data is not correct, check and try again'], 400);
        }
    }

}
