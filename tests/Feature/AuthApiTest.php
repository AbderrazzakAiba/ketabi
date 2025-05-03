<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserStatus;

class AuthApiTest extends TestCase
{
    use RefreshDatabase; // Use RefreshDatabase to reset the database for each test

    /**
     * Test successful user login.
     *
     * @return void
     */
    public function test_user_can_login_with_correct_credentials()
    {
        // Create a user with approved status
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'status' => UserStatus::APPROVED,
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'access_token', 'token_type', 'user']);
    }

    /**
     * Test user login with incorrect password.
     *
     * @return void
     */
    public function test_user_cannot_login_with_incorrect_password()
    {
        // Create a user with approved status
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'status' => UserStatus::APPROVED,
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422) // Unprocessable Entity for validation errors
                 ->assertJsonValidationErrors('email');
    }

    /**
     * Test user login with incorrect email.
     *
     * @return void
     */
    public function test_user_cannot_login_with_incorrect_email()
    {
        // Create a user with approved status
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'status' => UserStatus::APPROVED,
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'wrong@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(422) // Unprocessable Entity for validation errors
                 ->assertJsonValidationErrors('email');
    }

     /**
     * Test user cannot login if account is pending.
     *
     * @return void
     */
    public function test_user_cannot_login_if_account_is_pending()
    {
        // Create a user with pending status
        $user = User::factory()->create([
            'email' => 'pending@example.com',
            'password' => Hash::make('password123'),
            'status' => UserStatus::PENDING,
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'pending@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(422) // Unprocessable Entity for validation errors
                 ->assertJsonValidationErrors('email');
    }

    /**
     * Test accessing a protected route without authentication.
     *
     * @return void
     */
    public function test_cannot_access_protected_routes_without_authentication()
    {
        // Attempt to access a protected route (e.g., /api/user)
        // Explicitly set the guard to 'api' for this request
        $user = User::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->getJson('/api/users/' . $user->id);

        $response->assertStatus(401);
    }

    /**
     * Test accessing the test route.
     *
     * @return void
     */
    public function test_can_access_test_route()
    {
        $response = $this->getJson('/api/test-route');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Test route works!']);
    }
}
