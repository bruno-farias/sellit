<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Helpers\Creator;
use Tests\TestCase;

class CategoryTest extends TestCase
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

    public function testUserCanCreateCategory()
    {
        $categoryData = [
            'name' => $this->randoms->name()
        ];

        $this->actingAs($this->user)->json('POST', '/api/categories', $categoryData)
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'name',
                'created_at',
                'updated_at'
            ]);
    }

    public function testUserCantCreateCategoryWithMissingParameter()
    {
        $this->actingAs($this->user)->json('POST', '/api/categories', [])
            ->assertStatus(422);
    }

    public function testUserCanUpdateCategoryName()
    {
        $category = $this->creator->createCategory();
        $categoryData = [
            'id' => $category->id,
            'name' => $this->randoms->name()
        ];

        $this->actingAs($this->user)->json('PUT', '/api/categories/' . $category->id, $categoryData)
            ->assertOk()
            ->assertJson([
                'id' => $category->id,
                'name' => $categoryData['name'],
                'created_at' => $category->created_at,
                'updated_at' => Carbon::now()
            ]);
    }

    public function testUserCanSeeCategoryDetails()
    {
        $category = $this->creator->createCategory();
        $this->actingAs($this->user)->json('GET', '/api/categories/' . $category->id)
            ->assertOk()
            ->assertJson([
                'id' => $category->id,
                'name' => $category->name,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
            ]);
    }

    public function testUserCanListCategories()
    {
        $quantity = rand(1, 10);
        $categories = $this->creator->createCategories($quantity);

        $this->actingAs($this->user)->json('GET', '/api/categories')
            ->assertOk()
            ->assertJson($categories->toArray());
    }

    public function testUserCanDeleteCategory()
    {
        $category = $this->creator->createCategory();
        $this->actingAs($this->user)->json('DELETE', '/api/categories/' . $category->id)
            ->assertOk();
    }

    public function testUserCantDeleteCategoryThatHasProducts()
    {
        $category = $this->creator->createCategory();
        $this->creator->createProduct([
            'category_id' => $category->id
        ]);

        $this->actingAs($this->user)->json('DELETE', '/api/categories/' . $category->id)
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Can\'t delete category that has products!'
            ]);
    }
}
