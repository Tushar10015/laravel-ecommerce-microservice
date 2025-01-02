<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;

it('adds an item to the cart', function () {
    $response = $this->postJson('/api/cart/add', [
        'user_id' => 1,
        'product_id' => 101,
        'quantity' => 2,
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure(['cart_item' => ['id', 'cart_id', 'product_id', 'quantity']]);
});

it('views the cart', function () {
    $cart = Cart::factory()->create(['user_id' => 1]);
    CartItem::factory()->create(['cart_id' => $cart->id, 'product_id' => 101, 'quantity' => 2]);

    $response = $this->getJson('/api/cart?user_id=1');

    $response->assertStatus(200)
        ->assertJsonStructure(['cart' => ['id', 'items']]);
});

it('removes an item from the cart', function () {
    $cart = Cart::factory()->create(['user_id' => 1]);
    $cartItem = CartItem::factory()->create(['cart_id' => $cart->id, 'product_id' => 101]);

    $response = $this->postJson('/api/cart/remove', [
        'cart_id' => $cart->id,
        'product_id' => $cartItem->product_id,
    ]);

    $response->assertStatus(200)
        ->assertJson(['message' => 'Item removed successfully']);
});
