<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RedirectContorllerTest extends TestCase
{
    public function testRedirect(){
        $this->get('/redirect/from')
            ->assertRedirect('/redirect/to');
    }

    public function testRedirectAction(){
        $this->get('/redirect/action')
            ->assertRedirect('/redirect/hello/Azriel');
    }

    public function testRedirectAway(){
        $this->get('/redirect/google')
            ->assertRedirect('https://www.google.com');
    }

}
