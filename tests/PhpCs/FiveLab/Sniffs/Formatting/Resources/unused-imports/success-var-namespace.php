
<?php

use Bar;
use Baz;

class Foo
{
    public function foo(Baz $baz): void
    {
        /** @var Bar\Foo $foo */
        $foo = $baz->getFoo();
    }
}
