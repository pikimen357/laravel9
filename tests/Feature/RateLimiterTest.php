<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RateLimiterTest extends TestCase
{
    public function test_rate_unlimited_route(){

        for ($i = 1; $i <= 10000; $i++) {
            $response = $this->get('/');
            $response->assertStatus(302);
        }
    }

    public function test_rate_limit_redirect_route()
    {
        for ($i = 1; $i <= 60; $i++) {
            $response = $this->get('/product-redirect/1');
            $response->assertStatus(302); // redirect to 'produk/1'
        }

        // The fourth request exceeded the limit (60 per minute).
        $response = $this->get('/product-redirect/1');
        $response->assertStatus(429); // Too Many Requests
    }
}
