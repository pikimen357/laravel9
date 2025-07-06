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
    return "404 not found by vicky";
});

// template
Route::view('/home', 'hello', ['name' => 'Paniyem']);

Route::get('/landing', function () {
    return view('hello', ['name' => 'Sumijem']);
});

Route::get('/admin', function () {
    return view('admin.admin', ['admin_name' => 'Eko']);
});

// with params

Route::get('/products/{id}', function ($id) {
   return "Product ID: " . $id;
})->name('product.detail');

Route::get('/products/{id}/items/{item}', function ($id, $item) {
   return "Product ID: " . $id . " Item: " . $item;
})->name('product.item.detail');

Route::get('/categories/{id}', function ($categoryId) {
    return "Categories : " . $categoryId;
})->where('id', '[0-9]+')
    ->name('category.detail');

Route::get('/users/{id?}', function ($user = '404') {
    return "User " . $user;
})->name('user.detail');

//conflict (top down priority)

Route::get('/conflict/piki', function (string $name) {
    return "Hello piki,I hope you are fine";
});

Route::get('/conflict/{name}', function ($name) {
   return "Hello " . $name;
});

// using named route

Route::get('produk/{id}', function ($id){
    $link = route('product.detail', ['id' => $id]);
    return "Link : {$link}";
});

Route::get('product-redirect/{id}', function ($id){
    return redirect()->route('product.detail', ['id' => $id]);
});

