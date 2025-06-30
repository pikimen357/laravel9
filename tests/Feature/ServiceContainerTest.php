<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Data\Foo;
use App\Data\Bar;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceInd;

class ServiceContainerTest extends TestCase
{
    public function testDependency(){
        // $foo = new Foo();
        $foo1 = $this->app->make(Foo::class); //new Foo();
        $foo2 = $this->app->make(Foo::class); //new Foo();

        self::assertEquals("Foo", $foo1->foo());
        self::assertEquals("Foo", $foo2->foo());
        self::assertNotSame($foo1, $foo2); // ensure they are different instances
    }

    public function testBind(){

        // Using bind to ensure a new instance is created each time
        // This means the closure will be executed every time we resolve the class
        $this->app->bind(Person::class, function ($app) {
            return new Person("Vidky", "Pradana");
        });

        $person1 = $this->app->make(Person::class); // closure will be executed
        $person2 = $this->app->make(Person::class); // closure will be executed

        self::assertEquals("Vidky", $person1->firstName);
        self::assertEquals("Pradana", $person2->lastName);

        self::assertNotSame($person1, $person2); // ensure they are different instances
    }

    public function testSingleton(){

        // Using singleton to ensure the same instance is returned
        // This means the closure will only be executed once
        $this->app->singleton(Person::class, function ($app) {
            return new Person("Vidky", "Pradana");
        });

        $person1 = $this->app->make(Person::class); //new Person() if not exists
        $person2 = $this->app->make(Person::class); //returns the same instance

        self::assertEquals("Vidky", $person1->firstName);
        self::assertEquals("Pradana", $person2->lastName);

        self::assertSame($person1, $person2); // ensure they are same instances
    }

    public function testInstance(){
        $person = new Person("Vidky", "Pradana");
        $this->app->instance(Person::class, $person);


        $person1 = $this->app->make(Person::class); // returns the same instance
        $person2 = $this->app->make(Person::class); // returns the same instance

        self::assertEquals("Vidky", $person1->firstName);
        self::assertEquals("Pradana", $person2->lastName);
        self::assertSame($person1, $person2); // ensure they are same instances
        self::assertSame($person, $person1); // ensure the instance is the same
    }

    public function testDependencyInjection(){

        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });
        
        $foo = $this->app->make(Foo::class);
        $bar = $this->app->make(Bar::class); // Bar depends on Foo so it will resolve Foo automatically with singleton

        self::assertSame($foo, $bar->foo); // ensure Bar's foo is the same instance as Foo
    }

    public function testDependencyInjectionInClosure(){
        $this->app->singleton(Foo::class, function ($app){
            return new Foo();
        });

        // $app makes sure that the Foo instance is injected into Bar
        $this->app->singleton(Bar::class, function($app){
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });

        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($foo, $bar1->foo); 
        self::assertSame($bar1, $bar2); 
    }

    public function testInterfaceToClassBinding(){
        // $this->app->singleton(HelloService::class, HelloServiceInd::class);

        $this->app->singleton(HelloService::class, function ($app) {
            return new HelloServiceInd();
        });

        $helloService = $this->app->make(HelloService::class);
        $greetint = $helloService->hello("Darjo");

        self::assertEquals("Halo Darjo", $greetint);
        self::assertInstanceOf(HelloServiceInd::class, $helloService); // ensure the instance is of type HelloServiceInd
        
        self::assertSame($helloService, $this->app->make(HelloService::class)); // ensure the same instance is returned
    }

}
