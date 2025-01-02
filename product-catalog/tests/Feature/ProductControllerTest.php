<?php

namespace Tests\Feature;

use App\Models\Product;

it('fetches all products', function () {
    Product::factory()->count(5)->create();

    $response = $this->getJson('/api/products');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'products' => [['id', 'name', 'description', 'price', 'stock', 'created_at']],
        ]);
});

it('fetches a single product', function () {
    $product = Product::factory()->create();

    $response = $this->getJson("/api/products/{$product->id}");

    $response->assertStatus(200)
        ->assertJson([
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
            ],
        ]);
});

it('creates a product', function () {
    $data = [
        'name' => 'Test Product',
        'description' => 'A test product',
        'price' => 99.99,
        'stock' => 10,
    ];

    $response = $this->postJson('/api/products', $data);

    $response->assertStatus(201)
        ->assertJsonStructure(['product' => ['id', 'name', 'price']]);
});
