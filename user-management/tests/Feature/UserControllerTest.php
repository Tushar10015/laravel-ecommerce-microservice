<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\postJson;

it('registers a user', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'password' => 'password123',
    ];

    $response = postJson('/api/users/register', $data);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'user' => ['id', 'name', 'email', 'created_at'],
        ]);
});

it('logs in a user', function () {
    $user = User::factory()->create([
        'email' => 'jane.doe@example.com',
        'password' => Hash::make('password123'),
    ]);

    $response = postJson('/api/users/login', [
        'email' => 'jane.doe@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'user' => ['id', 'name', 'email'],
        ]);
});
