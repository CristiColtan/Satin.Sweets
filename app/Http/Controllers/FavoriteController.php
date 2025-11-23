<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductListResource;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $products = $user->favorites()->with(['media', 'categories'])->get();
        return response()->json([
            'ids' => $products->pluck('id'),
            'data' => ProductListResource::collection($products),
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $request->user()->favorites($product)->syncWithoutDetaching([$product->id]);
        return response()->json(['status' => 'ok']);
    }

    public function destroy(Request $request, Product $product)
    {
        $request->user()->favorites($product)->detach($product->id);
        return response()->json(['status' => 'ok']);
    }
}
