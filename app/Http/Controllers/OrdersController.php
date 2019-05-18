<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStore;
use App\Http\Requests\OrderUpdate;
use App\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrdersController extends Controller
{
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = Order::with('orderProducts')->get();
        return response()->json($orders);
    }

    /**
     * @param OrderStore $request
     * @return JsonResponse
     */
    public function store(OrderStore $request): JsonResponse
    {
        $payload = $request->only([
            'user_id',
            'customer_id',
            'notes',
        ]);

        $order = $this->orderService->create($payload);

        return response()->json($order);
    }

    public function finish(Order $order)
    {
        // todo: after add all orderItems
    }

    /**
     * @param Order $order
     * @return JsonResponse
     */
    public function show(Order $order): JsonResponse
    {
        return response()->json($order);
    }

    public function update(OrderUpdate $request, Order $order): JsonResponse
    {
        $params = $request->only([
            'id',
            'user_id',
            'nacustomer_idme',
            'notes'
        ]);

        $order = $this->orderService->update($order, $params);

        return response()->json($order);
    }

    public function destroy(Order $order): JsonResponse
    {
        $order = $this->orderService->destroy($order);

        return response()->json($order);
    }
}
