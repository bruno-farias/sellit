<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryStore;
use App\Http\Requests\CategoryUpdate;
use App\Services\CategoryService;

class CategoriesController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories =  Category::all();
        return response()->json($categories);
    }


    /**
     * @param CategoryStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryStore $request)
    {
        $name = $request->get('name');
        $category = $this->categoryService->create($name);

        return response()->json($category);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdate $request, Category $category)
    {
        $name = $request->get('name');
        $category = $this->categoryService->update($category, $name);

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($this->categoryService->destroy($category)) {
            return response()->json([]);
        }

        return response()->json([
            'message' => 'Can\'t delete category that has products!'
        ], 401);
    }
}
