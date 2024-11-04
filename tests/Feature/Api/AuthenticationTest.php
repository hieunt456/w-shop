<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Tests\TestCase;
use WolfShop\Models\User;

class AuthenticationTest extends TestCase
{
    public function testLoginWithValidCredentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Authenticated.',
                'data' => [
                    'token' => $response['data']['token'], // Check that a token is returned
                ],
                'status' => 200,
            ]);

        $this->assertAuthenticatedAs($user);
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid credentials.',
                'status' => 401,
            ]);

        $this->assertGuest();
    }
}
