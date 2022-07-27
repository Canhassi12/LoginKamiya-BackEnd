<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginUserTest extends TestCase
{
    /**
     *
     * @test
     */
    public function user_login_and_return_access_token(): void
    {
        $user = User::factory()->create();

        $token = csrf_token();

        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'linguica2',
            '_token' => $token
        ])
        ->assertOk()
        ->assertSee('token');
    }

    /**
     *
     * @test
     */
    public function invalid_user_login(): void
    {    
        $this->post('/api/auth/login', [
            'email' => 'kamiya',
            'password' => 'kamiya',
        ])
        ->assertStatus(401);   
    }
}
