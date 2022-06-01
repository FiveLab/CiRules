<?php

function foo(string $a, int $b): void
{
}

function bar(string $a, int &$b): void
{
}

class FooBar
{
    public function foo(array $a): void
    {
    }

    public function bar(array &$b): void
    {
    }
}
