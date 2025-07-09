<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CookieController extends Controller
{

    public function setCookie(Request $request): Response {
        return response("Hello from cookie")
                    ->cookie('User-Id', 'pradana', 1000, '/') // set cookie with value pradana and 1000 minute exp
                    ->cookie('Is-Member', 'true', 1000, '/');
    }

    public function getCookie(Request $request): JsonResponse{
        return response()
            //  retrieve cookies then return into json format
            ->json([
                'userId' => $request->cookie('User-Id', 'guest'),
                'isMember' => $request->cookie('Is-Member', 'false'),
            ]);
    }

    public function clearCookie(Request $request): Response{

        return response("clear Cookie")
            ->withoutCookie('User-Id') // actually, set the id to empty
            ->withoutCookie('Is-Member'); // actually, set the date to expire
    }
}
