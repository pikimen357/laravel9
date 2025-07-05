<?php

namespace App\Services;

class MonggoJawir implements MonggoService {
    public function monggo(string $asma, int $yuswa): string {
        if ($yuswa < 30) {
            return "Mas " . $asma . ", koe isih enom!";
        } elseif ($yuswa >= 30 && $yuswa < 60) {
            return "Monggo ndereaken bapak " . $asma . ", sampeyan wis cukup umur!";
        } else {
            return "Monggo ndereaken kakung " . $asma . ", panjenengan sampun sepuh";
        }
    }
}

?>