<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class URLgenerationTest extends TestCase
{
    public function testUrlGeneration(){
        $response = $this->get('/url/current?name=Eko');
        $response->assertSeeText("/url/current?name=Eko");
    }

    public function testNamedRoute(){
        $response = $this->withHeader('X-API-KEY', 'Vap01')
                        ->get('/redirect/named');

        $response->assertSeeText("/redirect/hello/Sumijem");
    }

    public function testAction(){
        $response = $this->get('/url/action');
        $response->assertSeeText("/form");
    }
}
