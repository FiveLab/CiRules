<?php

use Bar1;
use Bar2;
use Bar3;
use Bar4;
use Bar5;
use Bar6;

/** *
 * @implements \Iterator<Bar1>
 */
class Foo implements \Iterator
{
}

/**
 * @implements \Iterator<string, Bar2>
 */
class FooSecondIterator implements \Iterator
{
}

/**
 * @extends \ArrayIterator<Bar3>
 */
class FooThirdIterator extends \ArrayIterator
{
}

/**
 * @extends \ArrayIterator<string, Bar4>
 */
class FooFourthIterator extends \ArrayIterator
{
}

/**
 * @extends Foo<Bar5, Bar6>
 */
class SomeExtends extends Foo
{
}
