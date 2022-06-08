<?php

function foo(): void
{
    $bar = [
        'foo'  => 1,
        'bar'  => 2,
        'some' => [
            'bar' => 'foo',
            'foo' => 'bar',
        ],
    ];
}

function result(): array
{
    return [
        'bar' => 'foo',
        'foo' => 'bar',
    ];
}

function result2(): array
{
    $a = ['foo' => 'bar', 'bar' => 'foo'];
    $b = ['some' => 'abra'];

    return \array_merge($a, $b);
}

switch (1) {
    case true:
        $result = [
            'foo' => 'bar',
        ];
        break;
}
