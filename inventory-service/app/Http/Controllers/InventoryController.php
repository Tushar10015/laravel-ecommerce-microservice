<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function addProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::create($validated);

        return response()->json(['product' => $product], 201);
    }

    public function listProducts()
    {
        $products = Product::all();
        return response()->json(['products' => $products]);
    }

    public function updateStock(Request $request, $id)
    {
        $validated = $request->validate([
            'stock' => 'required|integer',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update(['stock' => $validated['stock']]);

        return response()->json(['product' => $product]);
    }

    public function viewProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['product' => $product]);
    }
}
