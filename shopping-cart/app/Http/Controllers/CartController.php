<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        // Find or create a cart for the user
        $cart = Cart::firstOrCreate(['user_id' => $validated['user_id']]);

        // Add item to cart or update quantity if it already exists
        $cartItem = $cart->items()->updateOrCreate(
            ['product_id' => $validated['product_id']],
            ['quantity' => $validated['quantity']]
        );

        return response()->json(['cart_item' => $cartItem], 201);
    }

    public function removeItem(Request $request)
    {
        $validated = $request->validate([
            'cart_id' => 'required|integer',
            'product_id' => 'required|integer',
        ]);

        $cartItem = CartItem::where('cart_id', $validated['cart_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Item not found in cart'], 404);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Item removed successfully']);
    }

    public function viewCart(Request $request)
    {
        $cart = Cart::with('items')->where('user_id', $request->get('user_id'))->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        return response()->json(['cart' => $cart]);
    }

    public function clearCart(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
        ]);

        $cart = Cart::where('user_id', $validated['user_id'])->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $cart->items()->delete();

        return response()->json(['message' => 'Cart cleared successfully']);
    }
}
