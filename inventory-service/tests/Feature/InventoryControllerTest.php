<?php

namespace Tests\Feature;

use App\Models\Product;

it('adds a new product', function () {
    $response = $this->postJson('/api/inventory', [
        'name' => 'Product A',
        'stock' => 50,
        'price' => 100.00,
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure(['product' => ['id', 'name', 'stock', 'price']]);
});

it('lists all products', function () {
    Product::factory(3)->create();

    $response = $this->getJson('/api/inventory');

    $response->assertStatus(200)
        ->assertJsonStructure(['products' => [['id', 'name', 'stock', 'price']]]);
});

it('updates product stock', function () {
    $product = Product::factory()->create();

    $response = $this->putJson("/api/inventory/{$product->id}", [
        'stock' => 100,
    ]);

    $response->assertStatus(200)
        ->assertJson(['product' => ['stock' => 100]]);
});

it('views a single product', function () {
    $product = Product::factory()->create();

    $response = $this->getJson("/api/inventory/{$product->id}");

    $response->assertStatus(200)
        ->assertJsonStructure(['product' => ['id', 'name', 'stock', 'price']]);
});
