<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

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

// limiting get with mxAttemps:60 by user id or ip address
RateLimiter::for('get', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});

Route::get('/', function () {
    return view('welcome');
});

//------- Example of custom routing -------

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
Route::prefix('conflict')->group(function () {

    Route::get('/piki', function () {
        return "Hello piki,I hope you are fine";
    });

    Route::get('/{name}', function ($name) {
        return "Hello " . $name;
    });
});

Route::middleware(['throttle:get'])->group(function () {

    // using named route
    Route::get('produk/{id}', function ($id){
        $link = route('product.detail', ['id' => $id]);
        return "Link : {$link}";
    });

    Route::get('product-redirect/{id}', function ($id){
        return redirect()->route('product.detail', ['id' => $id]);
    });

});

// from controller

//Route::get(
//            '/controller/hello',
//            [\App\Http\Controllers\HelloController::class, 'hello']
//          );

Route::prefix('controller')->group(function () {

    Route::get(
            'hello/request/',
            [App\Http\Controllers\HelloController::class, 'request']
           )->name('hello.request.controller');

    Route::get(
                '/hello/{name}/{age}',
                 [\App\Http\Controllers\HelloController::class, 'hello']
              )->name('hello.detail.controller');

});

// CSRF protection will not be applied for this route group
// Route::withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->group(function () {

    Route::prefix('input')->group(function () {
        Route::post('/hello', [\App\Http\Controllers\InputController::class, 'hello']
                    )->name('input.hello');

        Route::match(['get', 'post', 'put'], '/hello/match/{name?}',
                    [\App\Http\Controllers\InputController::class, 'helloMatch'])->name('hello.match');

        Route::post('/hello/first',
                    [App\Http\Controllers\InputController::class, 'helloFirstName']
                    );

        // All input
        Route::post('/hello/input',
                    [App\Http\Controllers\InputController::class, 'helloInputAll']);

        Route::post('/hello/array',
                    [App\Http\Controllers\InputController::class, 'helloArray'])
                    ->name('input.array');

        // input type
        Route::post('/type',
                    [App\Http\Controllers\InputController::class, 'inputType']);

        // path '/input/filter'
        Route::prefix('filter')->group(function () {

            Route::post('/only',
                        [App\Http\Controllers\InputController::class, 'filterOnly'])
                    ->name('filter.only');

            Route::post('/except',
                        [App\Http\Controllers\InputController::class, 'filterExcept'])
                    ->name('filter.except');

            Route::post('/merge',
                        [App\Http\Controllers\InputController::class, 'filterMerge'])
                    ->name('filter.merge');

        });

    });

    Route::post('/file/upload',
                [\App\Http\Controllers\FileUploadController::class, 'upload']
                ); /** ->withoutMiddleware([ \App\Http\Middleware\VerifyCsrfToken::class
            ]); */

// });

Route::prefix('response')->group(function () {

    Route::get('/hello',
                [\App\Http\Controllers\ResponseController::class, 'response']
                )->name('response.hello');;

    Route::get('/header',
                [\App\Http\Controllers\ResponseController::class, 'header']
                )->name('response.header');

    Route::prefix('type')->group(function () {

            Route::get('/view',
                    [\App\Http\Controllers\ResponseController::class, 'responseView']
                    );

            Route::get('/json',
                        [\App\Http\Controllers\ResponseController::class, 'responseJson']
                        );

            Route::get('/file',
                        [\App\Http\Controllers\ResponseController::class, 'responseFile']
                        );

            Route::get('/download',
                        [\App\Http\Controllers\ResponseController::class, 'responseDownload']
                        );

        });
});

//Route::prefix('cookie')->group(function () {
//
//    Route::get('/set',
//            [\App\Http\Controllers\CookieController::class, 'setCookie']);
//
//    Route::get('/get',
//            [\App\Http\Controllers\CookieController::class, 'getCookie'])
//            ->name('cookie.get');
//
//    Route::get('/clear',
//                [\App\Http\Controllers\CookieController::class, 'clearCookie']
//                )->name('cookie.clear');;
//
//});

// grouping routes that have same controller class
Route::controller(\App\Http\Controllers\CookieController::class)->group(function () {
    Route::get('/cookie/set', 'setCookie')
            ->name('cookie.set');
    Route::get('/cookie/get', 'getCookie')
            ->name('cookie.get');
    Route::get('/cookie/clear', 'clearCookie')
            ->name('cookie.clear');;
});

// combining route groups (controller & middleware)
// and can use like controlle()->prefix()->middleware() ...
Route::controller(\App\Http\Controllers\RedirectController::class)
    ->prefix('redirect')
    ->middleware(['throttle:get', 'contoh:Vap01,401'])
    ->group(function () {
    Route::get('/from', 'redirectFrom')
                    ->name('redirect.from');

    Route::get('/to','redirectTo')
                    ->name('redirect.to');

    Route::get('/hello/{name}', 'redirectHello')
            ->name('redirect.hello');

    Route::get('/action','redirectAction');

    Route::get('/google','redirectAway');
});

//Route::get('/middleware/api', function () {
//   return "OK";
//})->middleware([\App\Http\Middleware\ContohMiddleware::class]);

//Route::prefix('middleware')->group(function () {
//
//    Route::get('/api', function () {
//       return "OK";
//    })->middleware(['contoh:Vap01,401']); // (alias_middleware_name: param1, param2)
//
//    Route::get('/group', function () {
//        return "Middleware Group";
//    })->middleware(['pzn']);
//
//});

//                 (alias_middleware_name: param1, param2)
Route::middleware(['contoh:Vap01,401'])->prefix('middleware')->group(function () {

//    Route::prefix('middleware')->group(function () {

        Route::get('/api', function () {
           return "OK";
        });

        Route::get('/group', function () {
            return "Middleware Group";
        });

//    });
});

Route::get('/form',
            [\App\Http\Controllers\FormController::class, 'form']);

Route::post('/form',
            [\App\Http\Controllers\FormController::class, 'submitForm']);

Route::get('/url/current', function () {
    return \Illuminate\Support\Facades\URL::full();
});

Route::get('/redirect/named', function () {
//    return route('redirect.hello', ['name' => 'Sumijem']);
    //return redirect()->route('redirect.hello', ['name' => 'Sumijem']);
    return \Illuminate\Support\Facades\URL::route('redirect.hello', ['name' => 'Sumijem']);
});

Route::get('url/action', function () {
//    return action([\App\Http\Controllers\FormController::class, 'form'], []);
//    return \Illuminate\Support\Facades\URL::action([\App\Http\Controllers\FormController::class, 'form'], []);
    return url()->action([\App\Http\Controllers\FormController::class, 'form'], []);
});

Route::prefix('session')->group(function () {

    Route::get('/create',
            [\App\Http\Controllers\SessionController::class, 'createSession']);

    Route::get('/get',
                [\App\Http\Controllers\SessionController::class, 'getSession']);;

    Route::get('/delete',
                [\App\Http\Controllers\SessionController::class, 'deleteSession']);
});

Route::get('/error/sample', function () {
    throw new \Exception('Always Error');
});

Route::get('/error/manual', function () {
    report(new \Exception("Sample error"));
    return "OK";
});

Route::get('/error/validation', function () {
    throw new \App\Exceptions\ValidationException("Sample error");;
});


