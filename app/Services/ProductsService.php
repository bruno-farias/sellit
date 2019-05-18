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


}