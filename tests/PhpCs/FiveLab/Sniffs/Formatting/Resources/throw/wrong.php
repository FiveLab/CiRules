<?php

function foo(): void
{
    $bar = 1;
    throw new \RuntimeException('bar foo');
}

function bar(): void
{
    throw new \RuntimeException(
        \sprintf('Foo Bar %s', 'Some')
    );
}