<?php

class Foo
{
    public function __construct($param1)
    {
    }

    public function __destruct($param1)
    {
    }

    public function bar(string $param1, $param2)
    {
        return '';
    }
}

function foo($param1, string $param2) {
    return '';
}
