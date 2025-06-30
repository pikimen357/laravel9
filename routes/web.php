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

Route::get('/hello', function () {
    return '<h1 style="color: brown;">Hello, World!</h1>';
});

Route::get('/menu', function () {
    return response()->json([
        'menu' => [
            ['name' => 'Nasi Goreng', 'price' => 25000],
            ['name' => 'Mie Ayam', 'price' => 20000],
        ],
    ]);
});