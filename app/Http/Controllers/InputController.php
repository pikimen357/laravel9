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

    public function helloFirstName(Request $request){

        if($request->has('name')){
             // nested array using .
            $firstName = $request->input('name.first');
            return "Hello $firstName";
        }
         return "name is not set!";
    }

    public function helloMatch(Request $request, string $name = null): string
    {
        if ($request->isMethod('post')) {
            return "Hello from post ". ($name ?? 'Guest');
        } elseif ($request->isMethod('get')) {
            return "Hello from get";
        } else {
            return "Hello from put";
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

    public function inputType(Request $request): string {
        $name = $request->input('name');
        $isMarried = $request->boolean('isMarried'); // auto boolean input
        $birthDate = $request->date('birthDate', 'Y-m-d'); // auto date input

        return json_encode([
           "name"  => $name,
           "married status" => $isMarried,
           "birth date" => $birthDate->format('Y-m-d')
        ]);
    }

    public function filterOnly(Request $request): string{

        // get name.first & name.last only
        $name = $request->only('name.first','name.last');

        return json_encode($name);
    }

    public function filterExcept(Request $request): string{

        // get data except admin
        $user = $request->except('admin');

        return json_encode($user);
    }

    public function filterMerge(Request $request): string{

        // whatever the input, admin = false
        $request->merge(['admin' => false]);
        $user = $request->input();

        return json_encode($user);
    }
}
