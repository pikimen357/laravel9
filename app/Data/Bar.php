<?php

namespace App\Data;

class Bar {
    public Foo $foo;

    // recommended to use constructor injection for dependencies
    public function __construct(Foo $foo) {
        $this->foo = $foo;
    }


    public function bar(): string {
        return $this->foo->foo() . " and Bar";
    }
 }

?>