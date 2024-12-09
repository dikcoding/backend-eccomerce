<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create(OrderCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = Auth::user();
        $order = new Order($data);
        $order->customer_id = $user->id;
        $order->save();

        return (new OrderResource($order))->response()->setStatusCode(201);
    }

    public function get(int $id): OrderResource
    {
        $order = Order::find($id);

        if (!$order) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    "message" => [
                        "Order not found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        return new OrderResource($order);
    }

    public function getAll(): JsonResponse
    {
        $user = Auth::user();
        $orders = Order::where('customer_id', $user->id)->get();

        return (OrderResource::collection($orders)->response()->setStatusCode(200));
    }
}
