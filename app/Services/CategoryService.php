<?php


namespace App\Services;


use App\Category;

class CategoryService
{
    /** @var Category $model */
    private $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function create(string $name): Category
    {
        $category = $this->model->create(['name' => $name]);
        $category->save();

        return $category;
    }

    /**
     * @param Category $category
     * @param string $name
     * @return Category
     */
    public function update(Category $category, string $name): Category
    {
        $category->name = $name;
        $category->save();
        return $category;
    }

    public function destroy(Category $category)
    {
        if ($category->products->count() > 0) {
            return false;
        }

        return $category->delete();
    }
}