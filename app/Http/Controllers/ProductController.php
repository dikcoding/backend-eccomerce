<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function create(ProductCreateRequest $request): JsonResponse
    {

        $data = $request->validated();
        $user = Auth::user();

        $product = new Product($data);
        $product->user_id = $user->id;
        $product->save();

        return (new ProductResource($product))->response()->setStatusCode(201);
    }

    public function get(int $id): ProductResource
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    "message" => [
                        "not found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        return new ProductResource($product);
    }

    public function update(int $id, ProductUpdateRequest $request): ProductResource
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    "message" => [
                        "not found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        $data = $request->validated();
        $product->fill($data);
        $product->save();

        return new ProductResource($product);
    }
}
