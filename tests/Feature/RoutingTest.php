<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testBasicRouting()
    {
        $this->get('/hello')
            ->assertStatus(200)
            ->assertSee('Hello Everyone');
    }

    public function testRedirect(){
        $this->get('/')
            ->assertStatus(302)
            ->assertRedirect('/hello');
    }

    public function testFallback(){
        $this->get('/haheo')
            ->assertSee('404 not found');
    }

    public function testJson()
{
    $response = $this->get('/menu');

    $response->assertStatus(200)
             ->assertJsonStructure([
                 'menu' => [
                     ['name', 'price'],
                 ],
             ])
//             ->assertJsonFragment([
//                 'name' => 'Nasi Goreng',
//                 'price' => 25000,
//             ])
             ->assertJsonFragment([
                 'name' => 'Mie Ayam',
                 'price' => 21000,
             ]);
}


}
