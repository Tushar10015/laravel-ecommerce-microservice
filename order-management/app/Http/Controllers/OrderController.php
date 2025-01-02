<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Check and calculate total amount via Product Catalog Service
        $totalAmount = 0;
        foreach ($validated['items'] as $item) {
            $response = Http::get("http://product-catalog-service/api/products/{$item['product_id']}");

            if ($response->failed()) {
                return response()->json(['message' => 'Product not found'], 404);
            }

            $product = $response->json();
            $totalAmount += $product['product']['price'] * $item['quantity'];
        }

        // Create the order
        $order = Order::create([
            'user_id' => $validated['user_id'],
            'total_amount' => $totalAmount,
        ]);

        // Add items to the order
        foreach ($validated['items'] as $item) {
            $response = Http::get("http://product-catalog-service/api/products/{$item['product_id']}");
            $product = $response->json();

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product['product']['price'],
            ]);
        }

        return response()->json(['order' => $order->load('items')], 201);
    }

    public function viewOrder($id)
    {
        $order = Order::with('items')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['order' => $order]);
    }

    public function listOrders(Request $request)
    {
        $orders = Order::with('items')->where('user_id', $request->get('user_id'))->get();

        return response()->json(['orders' => $orders]);
    }
}
