<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_correct_credentials(): void
    {
        $role = Role::create(['name' => 'Staff', 'slug' => 'staff', 'level' => 5]);
        $user = User::factory()->create([
            'email' => 'staff@20mefree.com',
            'password' => 'password123',
            'role_id' => $role->id,
        ]);

        $response = $this->post('/login', [
            'email' => 'staff@20mefree.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        User::factory()->create([
            'email' => 'staff@20mefree.com',
            'password' => 'password123',
        ]);

        $response = $this->post('/login', [
            'email' => 'staff@20mefree.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_view_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee($user->name);
    }
}
