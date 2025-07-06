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
            ->assertSee('404 not found by vicky');
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

    public function testRouteParameter(){
        $this->get('/products/1')
            ->assertSeeText('Product ID: 1');

        $this->get('/products/19')
            ->assertSeeText('Product ID: 19');

        $this->get('/products/13/items/xyz')
            ->assertSeeText('Product ID: 13 Item: xyz');

        $this->get('/products/-1/items/xyz')
            ->assertSee('Product ID: -1 Item: xyz');
    }

    public function testParameterRegex(){
        $this->get('/categories/13')
            ->assertSeeText('Categories : 13');

        $this->get('/categories/-2')
            ->assertSeeText('404 not found by vick');
    }

    public function testRouteOptionalParameter(){
        $this->get('/users/')
            ->assertSeeText('User 404');

        $this->get('/users/farhan')
            ->assertSeeText('User farhan');
    }

    public function testConflictRoute(){
        $this->get('/conflict/vidky')
            ->assertSeeText('Hello vidky');

        $this->get('/conflict/piki')
            ->assertSeeText('Hello piki,I hope you are fine');
    }

    public function testNamedRoute(){

        $this->get('produk/341')
            ->assertSeeText('Link : http://localhost/products/341');

        $this->get('product-redirect/12')
            ->assertRedirect('products/12');
    }

}
