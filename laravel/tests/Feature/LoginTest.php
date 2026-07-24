<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_login_dapat_diakses(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_pengguna_dapat_login_dengan_kredensial_valid(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->post('/login', [
            'login' => 'user@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_gagal_dengan_password_salah(): void
    {
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->post('/login', [
            'login' => 'user@example.com',
            'password' => 'password_salah',
        ]);

        $this->assertGuest();
    }
}
