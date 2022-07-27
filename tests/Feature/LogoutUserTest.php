<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutUserTest extends TestCase
{
    /**
     * 
     *@test
     */
    public function logout_with_authenticated_user(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/api/auth/login', [
            'email' => $user->email, 
            'password' => 'linguica2',
        ]);

        $this->post('/api/auth/logout')
        ->assertStatus(204);
    }
    /**
     * 
     *@test
     */
    public function logout_with_unauthenticated_user(): void
    {
        $this->post('/api/auth/logout')
        ->assertStatus(401);
    }
}
