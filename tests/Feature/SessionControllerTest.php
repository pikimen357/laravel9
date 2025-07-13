<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    public function testCreateSession(){
        $response = $this->get('/session/create');
        $response->assertSeeText('Session created')
                ->assertSessionHas('userId', 'vidky')
                ->assertSessionHas('isMember', true);
    }

    public function testGetSession(){
        $response = $this->withSession(["userId" => "vidky", "isMember" => "true"])
                        ->get('/session/get');

        $response->assertSeeText('User Id :  vidky, Is Member :  true')
                ->assertSessionHas('userId', 'vidky')
                ->assertSessionHas('isMember', "true");
    }

    public function testdestroySession()
    {
        $response = $this->withSession(["userId" => "ratna", "isMember" => "true"])
                        ->get('/session/delete');

        $response->assertSeeText('Session ratna deleted');
    }
}
