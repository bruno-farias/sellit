<?php

namespace Tests\Feature;

use App\Order;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Helpers\Creator;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use DatabaseMigrations;

    /** @var Creator $creator */
    private $creator;
    /** @var User $user */
    protected $user;
    /** @var User $customer */
    private $customer;

    public function setUp(): void
    {
        parent::setUp();
        $this->creator = new Creator();
        $this->user = $this->creator->createUser();
        $this->customer = $this->creator->createUser();
    }

    public function testUserCanCreateOrder()
    {
        $orderData = [
            'user_id' => $this->user->id,
            'customer_id' => $this->customer->id,
            'notes' => $this->randoms->notes()
        ];

        $this->actingAs($this->user)->json('POST', '/api/orders/', $orderData)
            ->assertOk()
            ->assertJson($orderData);
    }

    public function testUserCantCreateOrderWithMissingParameter()
    {
        $orderData = [
            'user_id' => $this->user->id,
            'customer_id' => $this->customer->id,
            'notes' => $this->randoms->notes()
        ];

        $orderData = $this->creator->removeRandomArrayItem($orderData);

        $this->actingAs($this->user)->json('POST', '/api/orders/', $orderData)
            ->assertStatus(422);
    }

    public function testUserCanSeeOrderWIthProducts()
    {
        $order = $this->getOrder();

        $expected = $order->with('orderProducts')->find($order->id);

        $this->actingAs($this->user)->json('GET', '/api/orders/' . $order->id)
            ->assertOk()
            ->assertJson($expected->toArray());
    }

    public function testUserCanSeeAllOrdersWithProducts()
    {
        $items = rand(1, 10);
        /** @var Order $order */
        $order = $this->creator->createOrderWithProducts([
            'user_id' => $this->user->id,
            'customer_id' => $this->customer->id
        ], $items);

        $expected = $order->with('orderProducts')->get();

        $this->actingAs($this->user)->json('GET', '/api/orders/')
            ->assertOk()
            ->assertJson($expected->toArray());
    }

    public function testUserCanEditOrder()
    {
        $order = $this->getOrder();

        $orderData = [
            'id' => $order->id,
            'user_id' => $this->user->id,
            'customer_id' => $this->customer->id,
            'notes' => $this->randoms->notes()
        ];

        $this->actingAs($this->user)->json('PUT', '/api/orders/' . $order->id, $orderData)
            ->assertOk()
            ->assertJson($orderData);
    }

    public function testUserCantEditOrderWithMissingParameters()
    {
        $order = $this->getOrder();

        $orderData = [
            'id' => $order->id,
            'user_id' => $this->user->id,
            'customer_id' => $this->customer->id,
            'notes' => $this->randoms->notes()
        ];

        $orderData = $this->creator->removeRandomArrayItem($orderData);

        $this->actingAs($this->user)->json('PUT', '/api/orders/' . $order->id, $orderData)
            ->assertStatus(422);
    }

    public function testUserCanDeleteOrder()
    {
        $order = $this->getOrder();

        $this->actingAs($this->user)->json('DELETE', '/api/orders/' . $order->id)
            ->assertOk()
            ->assertJson([]);
    }

    public function testUserCanAddProductsToOrder()
    {
        $order = $this->getOrder();
        $product = $this->creator->createProduct();

        $payload = [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'price' => $this->randoms->price(),
            'quantity' => $this->randoms->quantity()
        ];

        $this->actingAs($this->user)->json('POST', '/api/order-products', $payload)
            ->assertOk()
            ->assertJson($payload);
    }

    /**
     * @return Order
     */
    private function getOrder(): Order
    {
        $order = $this->creator->createOrder([
            'user_id' => $this->user->id,
            'customer_id' => $this->customer->id
        ]);
        return $order;
    }
}
