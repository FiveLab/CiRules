<?php

enum SomeEnum: string {
    case Foo = 'FOO';
    case Bar = 'BAR';

    public function foo() : bool
    {
        return true;
    }
}

// success
$res = \in_array('a', ['a'], true);
$res = \in_array(1, [1], true);
$res = \in_array([1, 2], [1, 2, 3], true);

$res = \in_array(new stdClass(), [1, 'a']);
$res = \in_array(new stdClass(), [new stdClass(), 'a']);
$res = \in_array([new stdClass()], [new stdClass(), 1]);

$strict = true;
$res = \in_array(1, [1], $strict);

// errors
$res = \in_array('a', ['a']);
$res = \in_array(1, [1]);
$res = \in_array([1, 2], [1, 2, 3]);

$strict = false;
$res = \in_array('a', ['a'], $strict);

$res = \in_array(rand(0, 1) ? 1 : '1', [1, 2, 3]);

$res = \in_array('a', [SomeEnum::Foo, SomeEnum::Bar]);
$res = \in_array([new stdClass()], [new stdClass(), new stdClass()], true);

// ignore
$strict = rand(0, 1) === 1;
$res = \in_array('x', ['x'], $strict);

$args = ['a', ['a'], false];
$res = \in_array(...$args);

// fail-safe
$fn = 'in_array';
$res = $fn('a', ['a']);

// error
class Some23 {

    public SomeEnum $foo;

    function baz() : void
    {
        $res = \in_array($this->foo, [SomeEnum::Foo, SomeEnum::Bar], true);
    }
}
