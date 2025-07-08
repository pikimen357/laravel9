<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class EncryptTest extends TestCase
{
    public function testEncrypt(){
       $encrypt = Crypt::encrypt('Vidky Adhi Pradana');
       var_dump($encrypt);

       $decrypt = Crypt::decrypt($encrypt);

       self::assertEquals('Vidky Adhi Pradana', $decrypt);
    }
}
