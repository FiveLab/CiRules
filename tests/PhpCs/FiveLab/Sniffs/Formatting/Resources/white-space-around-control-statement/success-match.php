<?php

$foo = 'bar';

$message = match ($foo) {
    1 => 'Foo',
    2 => 'Bar',
    default => '123'
};

$bar = 'foo';

if (true) {
    $message = match ($foo) {
        2 => 'Bar',
        3 => 'Foo',
    };

    $bar = 'some';
}

function foo () {
    return match(true) {
        default => 1
    };
}
