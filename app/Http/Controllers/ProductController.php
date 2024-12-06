<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProductResource;
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
}
