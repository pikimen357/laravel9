<?php

namespace App\Http\Controllers;

use App\Services\HelloService;
use App\Services\MonggoService;
use Illuminate\Http\Request;

class HelloController extends Controller
{
    private MonggoService $monggoService;

    public function __construct(MonggoService $monggoService) {
        $this->monggoService = $monggoService;
    }

    // using Request
    public function hello(Request $request, string $name, int $age): string {

//        $request->path();
//        $request->url();
//        $request->fullUrl();

        return $this->monggoService->monggo($name, $age);
    }

    public function request(Request $request) {
        return  $request->path() . PHP_EOL .
                $request->url() . PHP_EOL .
                $request->fullUrl() . PHP_EOL .
                $request->method() . PHP_EOL .
                $request->header('Accept') . PHP_EOL;
    }
}
