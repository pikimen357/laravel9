<?php

namespace App\Services;

class HelloServiceInd implements HelloService{
    public function hello(string $name): string {
        return "Halo " . $name;
    }
}

?>