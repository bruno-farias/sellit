<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Helpers\Creator;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseMigrations;

    /** @var Creator $creator */
    private $creator;
    /** @var User $user */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->creator = new Creator();
        $this->user = $this->creator->createUser();
    }

    public function testUserCanCreateProduct()
    {
        $category = $this->creator->createCategory();
        $product = [
            'category_id' => $category->id,
            'name' => $this->randoms->name(),
            'description' => $this->randoms->description(),
            'price' => $this->randoms->price()
        ];

        $this->actingAs($this->user)->json('POST', '/api/products', $product)
            ->assertOk()
            ->assertJson([
                'category_id' => $category->id,
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price']
            ]);
    }

    public function testUserCantCreateProductWithMissingParameters()
    {
        $category = $this->creator->createCategory();
        $product = [
            'category_id' => $category->id,
            'name' => $this->randoms->name(),
            'description' => $this->randoms->description(),
            'price' => $this->randoms->price()
        ];

        $product = array_slice($product, rand(0, count($product)), 1);

        $this->actingAs($this->user)->json('POST', '/api/products', $product)
            ->assertStatus(422);
    }

    public function testUserCanUpdateProduct()
    {
        $product = $this->creator->createProduct();
        $newCategory = $this->creator->createCategory();
        $productUpdate = [
            'id' => $product->id,
            'category_id' => $newCategory->id,
            'name' => $this->randoms->name(),
            'description' => $this->randoms->description(),
            'price' => $this->randoms->price()
        ];

        $this->actingAs($this->user)->json('PUT', '/api/products/' . $product->id, $productUpdate)
            ->assertOk()
            ->assertJson($productUpdate);
    }

    public function testUserCantUpdateProductWithMissingParameters()
    {
        $product = $this->creator->createProduct();
        $newCategory = $this->creator->createCategory();
        $productUpdate = [
            'id' => $product->id,
            'category_id' => $newCategory->id,
            'name' => $this->randoms->name(),
            'description' => $this->randoms->description(),
            'price' => $this->randoms->price()
        ];

        $productUpdate = $this->creator->removeRandomArrayItem($productUpdate);

        $this->actingAs($this->user)->json('PUT', '/api/products/' . $product->id, $productUpdate)
            ->assertStatus(422);
    }

    public function testUserCanSeeProductDetails()
    {
        $product = $this->creator->createProduct();

        $this->actingAs($this->user)->json('GET', '/api/products/' . $product->id)
            ->assertOk()
            ->assertJson([
                'id' => $product->id,
                'category_id' => $product->category_id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price
            ]);
    }

    public function testUserCanGetListOfAllProducts()
    {
        $quantity = rand(1, 10);
        $products = $this->creator->createProducts($quantity);

        $this->actingAs($this->user)->json('GET', '/api/products')
            ->assertOk()
            ->assertJson($products->toArray());
    }

    public function testUserCanDeleteProduct()
    {
        $product = $this->creator->createProduct();
        $this->actingAs($this->user)->json('DELETE', '/api/products/' . $product->id)
            ->assertOk()
            ->assertJson([]);

    }
}
