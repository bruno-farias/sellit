<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryStore;
use App\Http\Requests\CategoryUpdate;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = Category::all();
        return response()->json($categories);
    }


    /**
     * @param CategoryStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryStore $request): JsonResponse
    {
        $name = $request->get('name');
        $category = $this->categoryService->create($name);

        return response()->json($category);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        return response()->json($category);
    }

    /**
     * @param CategoryUpdate $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryUpdate $request, Category $category): JsonResponse
    {
        $name = $request->get('name');
        $category = $this->categoryService->update($category, $name);

        return response()->json($category);
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        if ($this->categoryService->destroy($category)) {
            return response()->json([]);
        }

        return response()->json([
            'message' => 'Can\'t delete category that has products!'
        ], 401);
    }
}
