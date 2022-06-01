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
