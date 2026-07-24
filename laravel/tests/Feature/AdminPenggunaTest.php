<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPenggunaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_mengakses_data_pengguna(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->get('/admin/pengguna');

        $response->assertStatus(200);
    }
}
