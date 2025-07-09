<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CookieControllerTest extends TestCase
{
    public function testCreateCookie(){
        $this->get('/cookie/set')
            ->assertSeeText('Hello from cookie')
            ->assertCookie('User-Id', 'pradana')
            ->assertCookie('Is-Member', 'true');
    }

    public function testGetCookie(){
        $this->withCookie('User-Id', 'pradana')
            ->withCookie('Is-Member', 'true')
            ->get(route('cookie.get'))
            ->assertJson([
                'userId' => 'pradana',
                'isMember' => true
            ]);
    }
}
