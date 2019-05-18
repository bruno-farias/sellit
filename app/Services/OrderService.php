<?php


namespace App\Services;


use App\Order;

class OrderService
{
    /**
     * @var Order
     */
    private $model;

    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    public function create(array $payload): Order
    {
        $order = $this->model->create($payload);
        $order->save();

        return $order;
    }

    public function update(Order $order, array $params): Order
    {
        $order->update($params);
        $order->save();

        return $order;
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return $order;
    }

}