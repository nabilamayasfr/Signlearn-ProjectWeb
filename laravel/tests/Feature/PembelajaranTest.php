<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PembelajaranTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengguna_login_dapat_mengakses_pembelajaran(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/pembelajaran.index');

        $response->assertStatus(200);
    }
}
