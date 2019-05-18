<?php


namespace App\Services;


use App\Order;

class OrderService
{
    /**
     * @var Order
     */
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function store(array $payload): Order
    {
        $order = $this->order->create($payload);
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