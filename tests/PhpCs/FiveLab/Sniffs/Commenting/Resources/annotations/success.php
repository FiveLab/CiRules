<?php

/**
 * Some foo action
 */
function foo(): void
{
}

/**
 * Some bar action
 *
 * @param int    $a
 * @param string $b
 *
 * @return int
 *
 * @throws \Exception
 * @throws SomeException
 */
function bar(int $a, string $b): int
{
    return 1;
}

/**
 * @param array<string> $a
 * @param array<SomeObject> $b
 * @param array<int, string> $c
 *
 * @return array<string|SomeObject>
 * @return array{"foo": int, "bar": string}
 */
function baz(array $a, array $b, array $c): array
{
}
