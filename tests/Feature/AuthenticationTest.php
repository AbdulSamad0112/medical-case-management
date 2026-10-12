<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Valid login - valid credentials successfully authenticate on web.
     */
    public function test_valid_credentials_successfully_authenticate_on_web(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@jajalmedical.com',
            'password' => bcrypt('Admin@123456'),
            'role' => UserRole::ADMIN,
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@jajalmedical.com',
            'password' => 'Admin@123456',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test 2: Invalid login - invalid credentials are rejected on web.
     */
    public function test_invalid_credentials_are_rejected_on_web(): void
    {
        User::factory()->create([
            'email' => 'admin@jajalmedical.com',
            'password' => bcrypt('Admin@123456'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'admin@jajalmedical.com',
            'password' => 'WrongPassword999',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test web logout clears session.
     */
    public function test_web_logout_successfully_logs_out_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Test API login issues Sanctum token and user role.
     */
    public function test_api_login_issues_sanctum_token_with_valid_credentials(): void
    {
        User::factory()->create([
            'email' => 'admin@jajalmedical.com',
            'password' => bcrypt('Admin@123456'),
            'role' => UserRole::ADMIN,
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'admin@jajalmedical.com',
            'password' => 'Admin@123456',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Login successful.',
            ])
            ->assertJsonStructure([
                'success',
                'data' => [
                    'token',
                    'user' => ['id', 'name', 'email', 'role'],
                ],
                'message',
            ]);

        $this->assertEquals('admin', $response->json('data.user.role'));
    }

    /**
     * Test API login rejects invalid credentials with 401.
     */
    public function test_api_login_rejects_invalid_credentials_with_401(): void
    {
        User::factory()->create([
            'email' => 'admin@jajalmedical.com',
            'password' => bcrypt('Admin@123456'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'admin@jajalmedical.com',
            'password' => 'IncorrectPassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'data' => null,
                'message' => 'Invalid email or password.',
            ]);
    }

    /**
     * Test API logout revokes token.
     */
    public function test_api_logout_revokes_current_access_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => null,
                'message' => 'Logged out successfully.',
            ]);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}
