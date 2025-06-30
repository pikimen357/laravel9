<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Env;
use Tests\TestCase;

class EnvirontmentTest extends TestCase
{
    // public function testGetEnvIns(){
    //     $instagram = env('INSTAGRAM');
        
    //     self::assertEquals('vidky', $instagram);
    // }

    public function testGetEnvDb(){
        $db = env('DB_CONNECTION');
        
        self::assertEquals('mysql', $db);
    }

    public function testDefaultValue(){
        $author = env('DB_USERNAME', 'root');
 
        self::assertEquals('root', $author);
    }

    public function testDefaultEnv(){
        $username = Env::get('DB_USERNAME', 'root');

        self::assertEquals('root', $username);
    }
}
