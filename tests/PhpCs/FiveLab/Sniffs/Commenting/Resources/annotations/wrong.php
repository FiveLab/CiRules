<?php

/**
 * Foo action
 *
 * @return void
 */
function foo(): void
{
}

/**
 * Bar action
 *
 * @return int
 *
 * @throws \Some\Foo\Bar\Exception
 */
function bar(): int
{
    return 1;
}

/**
 * @param SomeObject[] $a
 * @param string[] $b
 *
 * @return int[]
 */
function baz(array $a, array $b, array $c): array
{
}
