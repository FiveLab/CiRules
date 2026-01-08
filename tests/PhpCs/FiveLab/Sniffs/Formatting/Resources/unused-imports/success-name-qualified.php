<?php

use Baz\Bar as Assert;

class Foo
{
    public function name(): void
    {
        $s = new Assert\NotBlank();
    }
}
