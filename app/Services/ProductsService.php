<?php


namespace App\Services;


use App\Product;

class ProductsService
{
    /** @var Product $model */
    private $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function create(array $payload): Product
    {
        $product = $this->model->create($payload);
        $product->save();

        return $product;
    }

    public function update(Product $product, array $params): Product
    {
        $product->update($params);
        $product->save();

        return $product;
    }

    public function destroy(Product $product): Product
    {
        $product->delete();
        return $product;
    }


}