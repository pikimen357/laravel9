<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function createSession(Request $request): string{
        $request->session()->put('userId', 'vidky');
        $request->session()->put('isMember', 'true');

        return "Session created";
    }

    public function getSession(Request $request): string {
        $userId = $request->session()->get('userId', 'guest');
        $isMember = $request->session()->get('isMember', 'false');

        return "User Id :  {$userId}, Is Member :  {$isMember}";
    }

    public function deleteSession(Request $request): string {
        $userId = $request->session()->get('userId');
        $request->session()->forget('userId');
        $request->session()->forget('isMember');

        return "Session $userId deleted";
    }
}
