<?php

function docComment()
{
    /**
     * Some additional comment
     */
    throw new \RuntimeException('with doc comment');
}

function bar()
{
   throw new \RuntimeException('foo bar');
}

function foo()
{
    // Some comment here
    throw new \RuntimeException('bar foo');
}

function withVar()
{
    $var = new \RuntimeException('some');

    throw $var;
}

function withSprintf()
{
    throw new \RuntimeException(\sprintf(
        'Fo Bar %s',
        'Some'
    ));
}

function withSwitch(): void
{
    switch (true) {
        default:
            throw new \RuntimeException('foo bar');
    }
}

function withTernary(): void
{
    $a = $b['foo'] ?: throw new \RuntimeException('some');
}

function withTernaryIsset(): void
{
    $a = $b['foo'] ?? throw new \RuntimeException('some');
}

function withMatch(): void {
    match(true) {
        default => throw new \RuntimeException('foo')
    };
}
