<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

it('creates an order', function () {
    Http::fake([
        'http://product-catalog-service/api/products/*' => Http::response([
            'product' => ['price' => 50],
        ]),
    ]);

    $response = $this->postJson('/api/orders', [
        'user_id' => 1,
        'items' => [
            ['product_id' => 101, 'quantity' => 2],
        ],
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure(['order' => ['id', 'total_amount', 'items']]);
});

it('retrieves an order', function () {
    $order = Order::factory()->hasItems(3)->create();

    $response = $this->getJson("/api/orders/{$order->id}");

    $response->assertStatus(200)
        ->assertJsonStructure(['order' => ['id', 'total_amount', 'items']]);
});
