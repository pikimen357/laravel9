<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Data\Foo;
use App\Data\Bar;
use App\Services\HelloService;
use App\Services\MonggoService;


class FooBarServiceProviderTest extends TestCase
{      
    public function testServiceProvider(){
        $foo1 = $this->app->make(Foo::class);
        $foo2 = $this->app->make(Foo::class);

        self::assertSame($foo1, $foo2, 'Foo instances should be the same due to singleton binding.');

        $bar = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($bar, $bar2, 'Bar instances should be the same due to singleton binding.');

        self::assertSame($foo1, $bar2->foo, 'Bar should have the same Foo instance as the singleton.');
    
    }

    public function testPropertySingletons(){
        $helloService1 = $this->app->make(HelloService::class);

        $helloService2 = $this->app->make(HelloService::class);

        self::assertSame($helloService1, $helloService2, 'HelloService instances should be the same due to singleton binding.');

    }

    public function testJawir(){
        $jawir1 = $this->app->make(MonggoService::class);
        $jawir2 = $this->app->make(MonggoService::class);

        self::assertSame($jawir1, $jawir2, 'MonggoService instances should be the same due to singleton binding.');

        self::assertEquals(
            "Mas Budi, koe isih enom!",
            $jawir1->monggo("Budi", 20),
            'MonggoService should return the correct greeting for a young person.'
        );
    }
}
