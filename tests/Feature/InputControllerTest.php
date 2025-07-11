<?php

namespace Tests\Feature;

use Illuminate\Foundaton\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{

    public function testInput(){
        $this->post('/input/hello?name=vidky&age=20')
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
                    ]])
                ->assertSeeText('Hello vidky')
                ->assertDontSee('name is not set!');

        $this->post('/input/hello/first',
                    ["age" => 20])
            ->assertSeeText("name is not set!");
    }

    public function testMatch(){

        $this->get('/input/hello/match/')
            ->assertSeeText('Hello from get');

        $this->post('/input/hello/match/heru')
            ->assertSeeText('Hello from post heru');

        $this->post('/input/hello/match/')
            ->assertSeeText('Hello from post Guest');

        $this->put('/input/hello/match/')
            ->assertSeeText('Hello from put');
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
            ->assertSeeText('burger')
            ->assertDontSeeText('10000');
    }

    public function testInputType(){
        $this->post('/input/type',
                    [
                        "name" => "vidky",
                        "isMarried" => false,
                        "birthDate" => "2001-05-22",
                    ])
            ->assertSeeText('vidky')
            ->assertSeeText('false')
            ->assertSeeText('2001-05-22');
    }

    public function testFilterOnly(){
        $this->post(route('filter.only'),
                    [ "name" => [
                        "first" => "vidky",
                        "middle" => "adhi",
                        "last" => "pradana"
                    ]])
            ->assertSeeText('vidky')
            ->assertDontSeeText('adhi')
            ->assertSeeText('pradana');
    }

    // route() to get url from named route
    public function testFilterExcept(){
        $this->post(route('filter.except'),
                    [   "username" => "vidky",
                        "admin" => true,
                        "password" => "vidky123"
                    ])
                ->assertSeeText('vidky')
                ->assertSeeText('vidky123')
                ->assertDontSeeText('true');
    }

    public function testFilterMerge(){
        $this->post(route('filter.merge'),
                    [   "username" => "vidky",
                        "admin" => true,
                        "password" => "vidky123"
                    ])
            ->assertSeeText('vidky')
            ->assertSeeText('vidky123')
            ->assertSeeText('false');
    }
}
