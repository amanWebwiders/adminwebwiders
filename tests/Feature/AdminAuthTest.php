<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Admin::create([
            'name' => 'System Admin',
            'email' => 'admin@blog.com',
            'password' => Hash::make('password123'),
        ]);
    }

    public function test_unauthenticated_user_redirected_to_admin_login()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_login_with_correct_credentials()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@blog.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs(Admin::first(), 'admin');
    }

    public function test_admin_cannot_login_with_incorrect_password()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@blog.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest('admin');
    }

    public function test_authenticated_admin_can_logout()
    {
        $admin = Admin::first();
        $this->actingAs($admin, 'admin');

        $response = $this->post('/admin/logout');
        $response->assertRedirect('/admin/login');
        $this->assertGuest('admin');
    }
}
