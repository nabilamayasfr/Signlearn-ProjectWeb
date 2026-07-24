<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BerandaTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengguna_login_dapat_mengakses_beranda(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/beranda');

        $response->assertStatus(200);
    }
}
