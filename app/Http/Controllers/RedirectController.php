<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirectTo(){
        return "Redirect to";
    }

    // redirect to named route
    public function redirectFrom(): RedirectResponse{
        return redirect(route('redirect.to'));
    }

    public function redirectHello(string $name): string{
        return "Hello from redirect {$name}";
    }

    // Redirect to the controller directly without specifying the URL
    public function redirectAction(): RedirectResponse{
        return redirect()
            ->action([RedirectController::class, 'redirectHello'],
                                    ['name' => 'Azriel']);
    }

    //Redirect to external web/domain
    public function redirectAway(): RedirectResponse{
        return redirect()
                ->away('https://www.google.com');
    }

}
