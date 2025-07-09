<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CookieController extends Controller
{

    public function setCookie(Request $request): Response {
        return response("Hello from cookie")
                    ->cookie('User-Id', 'pradana', 1000, '/') // 1000 minute cookie exp
                    ->cookie('Is-Member', 'true', 1000, '/');
    }

    public function getCookie(Request $request): JsonResponse{
        return response()
            //  getting cookie then returning the json response
            ->json([
                'userId' => $request->cookie('User-Id', 'guest'),
                'isMember' => $request->cookie('Is-Member', 'false'),
            ]);
    }

    public function clearCookie(Request $request): Response{

        return response("clear Cookie")
            ->withoutCookie('User-Id')
            ->withoutCookie('Is-Member');
    }
}
