<?php

class Foo
{
    public function __construct(string $param1)
    {
        $fn = static function(){

        };
    }

    public function __destruct(string $param1)
    {
    }

    public function bar(string $param1, string $param2): string
    {
        return '';
    }
}
