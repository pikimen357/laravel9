<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class AppEnvirontmentTest extends TestCase
{
    public function testAppEnv(){
        if(App::environment((['testing', 'prod', 'local']))){
            self::assertTrue(true);
        } else {
            self::assertTrue(false);
        }
    }
}
