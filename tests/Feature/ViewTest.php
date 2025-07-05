<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView(){
        $this->get('/home')
            ->assertStatus(200)
            ->assertSee('Monggo Paniyem');

        $this->get('/landing')
            ->assertStatus(200)
            ->assertSee('Monggo Sumijem');

    }

    public function testViewNesting(){
        $this->get('/admin')
            ->assertSee('Admin Eko');
    }

    // testing template without route
    public function testTemplateOnlyg(){
        $this->view('hello', ['name' => 'Paniyem'])
            ->assertSeeText('Monggo Paniyem');

        $this->view('admin.admin', ['admin_name' => 'Heru'])
            ->assertSeeText('Admin Heru');
    }
}
