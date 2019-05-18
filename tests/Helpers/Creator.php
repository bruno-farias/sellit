<?php


namespace Tests\Helpers;


use App\Category;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class Creator
{
    public function createUser(array $params = []): User
    {
        return factory(User::class)->create($params);
    }

    public function createCategory(array $params = []): Category
    {
        return factory(Category::class)->create($params);
    }

    public function createCategories(int $quantity = 1): Collection
    {
        return factory(Category::class, $quantity)->create();
    }

    public function createProduct(array $params = []): Product
    {
        return factory(Product::class)->create($params);
    }

    public function createProducts(int $quantity = 1): Collection
    {
        return factory(Product::class, $quantity)->create();
    }

    public function removeRandomArrayItem(array $array): array
    {
        return array_slice($array, rand(0, count($array)), 1);
    }

    public function createOrder(array $params): Order
    {
        return factory(Order::class)->create($params);
    }

    public function createOrderWithProducts(array $params, int $items = 1): Order
    {
        $order = factory(Order::class)->create($params);

        Collection::times($items, function () use ($order) {
            $product = factory(Product::class)->create();
            return factory(OrderProduct::class)->create([
                'order_id' => $order->id,
                'product_id' => $product->id
            ]);
        });

        return $order;
    }
}