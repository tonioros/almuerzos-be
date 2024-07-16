<?php

namespace App\Http\Controllers;

use App\Constants\OrderState;
use App\Jobs\CookingAnOrderJob;
use App\Models\Order;
use App\Models\Recipe;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get("status");
        $fcm_token = $request->get("fcm_token");
        $request_date = $request->get("request_date");
        $recipe_id = $request->get("recipe_id");
        $limit = $request->get("limit");
        $orderBy = $request->get("orderBy");
        $withRecipe = $request->get("withRecipe");
        $orderList = Order::query();

        if ($status) {
            $orderList->where('status', $status);
        }
        if ($fcm_token) {
            $orderList->where('fcm_token', $fcm_token);
        }
        if ($request_date) {
            $orderList->where('request_date', $request_date);
        }
        if ($recipe_id) {
            $orderList->where('recipe_id', $recipe_id);
        }
        if ($withRecipe) {
            $orderList->with(['recipe']);
        }
        if ($limit) {
            $orderList->limit($limit);
        }
        if ($orderBy) {
            $orderList->orderBy('id', $orderBy);
        }
        return $orderList->get();
    }

    /**
     * Create a new Order and add an event to queue
     * to send to Kitchen to start to cook
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
            // Load internal resources to show more details to user
            $order->recipe->ingredients;
            return $order;
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Order data is not correct, check and try again'], 400);
        }
    }

}
