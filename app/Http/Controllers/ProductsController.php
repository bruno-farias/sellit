<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStore;
use App\Http\Requests\ProductUpdate;
use App\Product;
use App\Services\ProductsService;
use Illuminate\Http\JsonResponse;

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
        $products = Product::all();

        return response()->json($products);
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
        return response()->json($product);
    }

    /**
     * @param ProductUpdate $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(ProductUpdate $request, Product $product): JsonResponse
    {
        $params = $request->only([
            'id',
            'category_id',
            'name',
            'description',
            'price'
        ]);
        $product = $this->productService->update($product, $params);

        return response()->json($product);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        $product = $this->productService->destroy($product);

        return response()->json($product);
    }
}
