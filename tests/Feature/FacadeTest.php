<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Facades\Config as FacadesConfig;
use Tests\TestCase;

class FacadeTest extends TestCase
{
    public function testConfig(){
        $firstName1 = config('app.first_name');
        $firstName2 = FacadesConfig::get('app.first_name'); // using Facade

        self::assertEquals($firstName1, $firstName2);

        // var_dump(FacadesConfig::all());
    }


    public function testConfigDependency(){

        $config = $this->app->make('config');
        $firstName3 = $config->get('app.first_name'); // using Service Container

        $firstName1 = config('app.first_name'); // using helper function
        $firstName2 = FacadesConfig::get('app.first_name'); // using Facade

        self::assertEquals($firstName1, $firstName2);
        self::assertEquals($firstName1, $firstName3);

        // var_dump($config->all());
    }

    public function testFacadeMock(){

        FacadesConfig::shouldReceive('get')
            ->with('app.first_name')
            ->andReturn('Heru'); // mocking the Facade

        $firstName = FacadesConfig::get('app.first_name');
        self::assertEquals('Heru', $firstName);
    }
}
