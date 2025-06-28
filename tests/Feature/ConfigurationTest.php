<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function testConfig(){
        $firestName = config('contoh.author.first');
        $lastName = config('contoh.author.last');
        $address = config('contoh.address');
        $phone = config('contoh.phone');

        self::assertEquals('vidky', $firestName);
        self::assertEquals('Pradana', $lastName);
        self::assertEquals('solo', $address);
        self::assertEquals('082223190195', $phone);
    }
}
