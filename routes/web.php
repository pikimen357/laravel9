<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//------- Example route that I created -------

Route::get('/menu', function () {
    return response()->json([
        'menu' => [
            ['name' => 'Nasi Goreng', 'price' => 25000],
            ['name' => 'Mie Ayam', 'price' => 21000],
        ],
    ]);
});

Route::get('/hello', function () {
   return "<h1>Hello Everyone</h1>";
});

Route::redirect('/', '/hello');

Route::fallback(function () {
    return "404 not found";
});

// template
Route::view('/home', 'hello', ['name' => 'Paniyem']);

Route::get('/landing', function () {
    return view('hello', ['name' => 'Sumijem']);
});

Route::get('/admin', function () {
    return view('admin.admin', ['admin_name' => 'Eko']);
});
