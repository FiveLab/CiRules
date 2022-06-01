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
