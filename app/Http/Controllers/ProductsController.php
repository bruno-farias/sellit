<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStore;
use App\Product;
use App\Services\ProductsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /** @var ProductsService $productService */
    private $productService;

    public function __construct(ProductsService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        //
    }

    /**
     * @param ProductStore $request
     * @return JsonResponse
     */
    public function store(ProductStore $request): JsonResponse
    {
        $payload = $request->only([
            'name',
            'category_id',
            'description',
            'price',
        ]);
        $product = $this->productService->create($payload);

        return response()->json($product);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        //
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        //
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        //
    }
}
