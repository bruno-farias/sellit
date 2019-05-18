<?php


namespace App\Services;


use App\OrderProduct;

class OrderProductService
{
    /** @var OrderProduct $orderProduct */
    private $orderProduct;

    public function __construct(OrderProduct $orderProduct)
    {
        $this->orderProduct = $orderProduct;
    }

    public function store(array $params): OrderProduct
    {
        $orderProduct = $this->orderProduct->create($params);
        $orderProduct->save();

        return $orderProduct;
    }

}