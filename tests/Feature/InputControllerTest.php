<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{

    public function testInput(){
        $this->get('/input/hello?name=vidky&age=20')
            ->assertSeeText('Mas vidky, koe isih enom!');

        $this->followingRedirects()
            ->post('/input/hello', ['name' => 'mujirah', 'age' => '80'])
            ->assertSeeText('Monggo ndereaken kakung mujirah, panjenengan sampun sepuh');
    }

    public function testInputNested(){
        $this->post('/input/hello/first',
                    ['name' => [
                        'first' => 'vidky',
                        'last' => 'pradana'
                    ]]
                    )
                ->assertSeeText('Hello vidky');
    }

    public function testMatch(){

        $this->get('/input/hello/match/')
            ->assertSeeText('Hello from get Guest');

        $this->get('/input/hello/match/fardan')
            ->assertSeeText('Hello from get fardan');

        $this->post('/input/hello/match/')
            ->assertSeeText('Hello from post');

        $this->put('/input/hello/match/')
            ->assertSeeText('Hello from matching');
    }

    public function testInputAll(){
        $this->post('/input/hello/input'
                    ,['name' => [
                        'first' => 'vidky',
                        'last' => 'pradana'
                    ]])
            ->assertSeeText('name')
            ->assertSeeText('first')
            ->assertSeeText('vidky')
            ->assertSeeText('last')
            ->assertSeeText('pradana');
    }

    public function testArrayInput(){
        $this->post('/input/hello/array',
                    ['products' => [
                        ['name' => 'pizza', 'price' => 10000],
                        ['name' => 'sushi', 'price' => 15000],
                        ['name' => 'burger', 'price' => 20000]
                    ]])
            ->assertSeeText('pizza')
            ->assertSeeText('sushi')
            ->assertSeeText('burger');
    }
}
