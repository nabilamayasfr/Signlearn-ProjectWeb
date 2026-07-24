<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LatihanTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengguna_tanpa_login_tidak_dapat_mengakses_latihan(): void
    {
        $response = $this->get('/latihan');

        $response->assertRedirect('/login');
    }

    public function test_pengguna_login_dapat_mengakses_latihan(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/latihan');

        $response->assertStatus(200);
    }
}
