<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_register_dapat_diakses(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_pengguna_dapat_melakukan_registrasi(): void
    {
        $unique = uniqid();

        $email = 'testing' . $unique . '@example.com';
        $username = 'testing' . $unique;

        $this->post('/register', [
            'nama_lengkap' => 'User Testing',
            'username' => $username,
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nomor_telepon' => '08123456789',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);
    }
}
