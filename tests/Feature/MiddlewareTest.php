<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    public function testInvalid(){
        $response = $this->get('/middleware/api');

        $response->assertSeeText('Unauthorized.')
                ->assertStatus(401);
    }

    public function testValid(){
        $response = $this->withHeader("X-API-KEY" , "Vap01")
            ->get('/middleware/api');

        $response->assertStatus(200)
            ->assertSeeText('OK');
    }

    public function testInvalidGroup(){
        $response = $this->get('/middleware/group');

        $response->assertStatus(401)
                ->assertSeeText('Unauthorized.');
    }

    public function testValidGroup(){
        $response = $this->withHeader("X-API-KEY" , "Vap01")
            ->get('/middleware/group');

          $response->assertStatus(200)
            ->assertSeeText('Middleware Group');
    }
}
