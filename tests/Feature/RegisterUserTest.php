<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use App\Services\ValidationUser;

class RegisterUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function if_user_data_is_added_in_database_and_return_access_token(): void
    {
        $newUser = User::factory()->make();

        $newUser->name;
        $newUser->email;
        $newUser->password;

        $token = csrf_token();

        $this->post('/api/register', [
            'name' => $newUser->name,
            'email' => $newUser->email, 
            'password' => $newUser->password, 
            '_token' => $token
        ])
            ->assertOk()
            ->assertSee('token');
    }

    /**
     * A basic feature test example.
     *
     * @test
     */
    public function invalid_user_register(): void 
    {
        $token = csrf_token();

        $this->post('/api/register', [
            'name' => 'kamiya',
            'email' => 'kamiya', 
            'password' => '', 
            '_token' => $token
        ])
        ->assertStatus(400);
    }

}
