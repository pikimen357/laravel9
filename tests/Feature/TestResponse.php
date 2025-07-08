<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestResponse extends TestCase
{
    public function testResponse(){
        $this->get('/response/hello')
            ->assertStatus(200)
            ->assertSee('Hello from response');
    }

    public function testHeader(){
        $this->get(route('response.header'))
            ->assertStatus(200)
            ->assertSee('Vidky')->assertSeeText('Pradana')
            ->assertHeader('Content-Type', 'multipart/form-data')
            ->assertHeader('Author', 'Programmer Ngakak')
            ->assertHeader('App', 'Belajar Laravel');
    }

    public function testView(){
        $this->get('/response/type/view')
            ->assertStatus(200)
            ->assertSeeText('Monggo Azriel');
    }

    public function testJson(){
        $this->get('/response/type/json')
            ->assertStatus(200)
            ->assertJson([
                    'firstname' => 'Azriel',
                    'lastname' => 'Alapi'
                    ]
            );
    }

    public function testFile(){
        $this->get('/response/type/download')
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'image/jpeg');
    }

    public function testDownload(){
        $this->get('/response/type/download')
            ->assertDownload('kera.jpg');
    }
}
