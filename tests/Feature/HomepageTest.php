<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class HomepageTest extends TestCase
{
    public function testHomepage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testLoginPage(): void
    {
        $response = $this->get('/auth/login');

        $response->assertStatus(200);
    }
}
