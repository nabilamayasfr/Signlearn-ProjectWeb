<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HistoriTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengguna_tanpa_login_tidak_dapat_mengakses_histori(): void
    {
        $response = $this->get('/histori');

        $response->assertRedirect('/login');
    }

    public function test_pengguna_login_dapat_mengakses_histori(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/histori');

        $response->assertStatus(200);
    }
}
