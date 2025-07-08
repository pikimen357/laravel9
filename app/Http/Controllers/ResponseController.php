<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponseController extends Controller
{
    public function response(Request $request): Response {
        return response("Hello from response", 200);
    }

    public function header(Request $request): Response{

        $headers = [
            'Author' => 'Programmer Ngakak',
            'App' => 'Belajar Laravel'
        ];

        $body = [
            'firstname' => 'Vidky',
            'lastname' => 'Pradana'
        ];

        return response(json_encode($body), 200)
            ->header('Content-Type', 'multipart/form-data')
            ->withHeaders($headers);
    }

    public function responseView(Request $request): Response {
        return response()->view('hello',
                                ["name" => "Azriel"]);
    }

    public function responseJson(Request $request): JsonResponse
    {
        $body = [
            'firstname' => 'Azriel',
            'lastname' => 'Alapi'
        ];

        return response()->json($body);
    }

    public function responseFile(Request $request): BinaryFileResponse{
        return response()
            ->file(storage_path('app/public/pictures/kera.jpg'));
    }

    public function responseDownload(Request $request): BinaryFileResponse
    {
        return response()
            ->download(storage_path('app/public/pictures/kera.jpg'), 'kera.jpg');
    }
}
