<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

use App\Services\HelloService;
use App\Services\HelloServiceInd;

use \App\Services\MonggoService;
use \App\Services\MonggoJawir;

use App\Data\Foo; 
use App\Data\Bar;


class FooBarServiceProvider extends ServiceProvider  implements DeferrableProvider
{
    public array $singletons = [
        // interface => class (implementation)
        HelloService::class => HelloServiceInd::class,
        MonggoService::class => MonggoJawir::class,
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // echo "Registering FooBarServiceProvider...\n";
        $this->app->singleton(Foo::class, function ($app){
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app){
            return new Bar($app->make(Foo::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    // registering the services (Defferable Provider)
    public function provides()
    {
        return [
            HelloService::class,
            MonggoService::class,
            Foo::class,
            Bar::class,
        ];
    }
}
