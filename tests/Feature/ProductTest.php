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
}
