<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminModulTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_mengakses_modul(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->get('/admin/modul');

        $response->assertStatus(200);
    }
}
