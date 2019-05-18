<?php

namespace App\Http\Controllers;


use App\Http\Requests\OrderProductStore;
use App\Http\Requests\OrderProductUpdate;
use App\OrderProduct;
use App\Services\OrderProductService;
use Illuminate\Http\JsonResponse;

class OrderProductsController extends Controller
{
    /** @var OrderProductService $orderProductService */
    private $orderProductService;

    public function __construct(OrderProductService $orderProductService)
    {
        $this->orderProductService = $orderProductService;
    }

    public function store(OrderProductStore $request): JsonResponse
    {
        $orderProduct = $request->only([
            'order_id',
            'product_id',
            'price',
            'quantity'
        ]);

        $orderProduct = $this->orderProductService->store($orderProduct);

        return response()->json($orderProduct);
    }

    public function update(OrderProductUpdate $request, OrderProduct $orderProduct): JsonResponse
    {
        $payload = $request->only([
            'id',
            'order_id',
            'product_id',
            'price',
            'quantity'
        ]);
        $orderProduct = $this->orderProductService->update($orderProduct, $payload);

        return response()->json($orderProduct);
    }

    public function destroy(OrderProduct $orderProduct): JsonResponse
    {
        $orderProduct->delete();

        return response()->json($orderProduct);
    }

}
