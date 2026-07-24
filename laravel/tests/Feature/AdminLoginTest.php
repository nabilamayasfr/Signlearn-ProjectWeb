<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    public function test_halaman_login_admin_dapat_diakses(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }
}
