<?php

namespace App\Http\Controllers;

use App\Services\MonggoService;
use Illuminate\Http\Request;

class InputController extends Controller
{
    private MonggoService $monggoService;

    public function __construct(MonggoService $monggoService) {
        $this->monggoService = $monggoService;
    }

    public function hello(Request $request): string {

        // $name = $request->name;
        $name = $request->input('name');
        $age = $request->input('age');

        $say = $this->monggoService->monggo($name, $age);

        return $say;
    }

    public function helloFirstName(Request $request): string{

        // nested array using .
        $firstName = $request->input('name.first');
        return "Hello $firstName";
    }

    public function helloMatch(Request $request, string $name = null): string
    {
        if ($request->method() === 'POST') {
            return "Hello from post";
        } elseif ($request->method() === 'GET') {
            return "Hello from get " . ($name ?? 'Guest');
        } else {
            return "Hello from matching";
        }
    }

    public function helloInputAll(Request $request): string{

        // get all input (array) from request body and url params(?)
        $input = $request->input();
        return json_encode($input);
    }


    public function helloArray(Request $request): string{

        //get all products[] name
        $names = $request->input('products.*.name');
        return json_encode($names);
    }

}
