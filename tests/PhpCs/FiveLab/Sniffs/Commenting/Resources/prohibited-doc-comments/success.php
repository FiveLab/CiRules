<?php

/**
 * Class Some
 */
class Some {

    /**
     * @var string
     */
    private string $foo;
    public const FOO = 'foo';
    const BAR = 'bar';

    /**
     * @return void
     */
    public function bla(): void
    {
        /**
         * @var string $foo
         */
        $foo = 'foo';
    }
}

/**
 * Abstract class Some2
 */
abstract class Some2 {}

/**
 * @final Class Some3
 */
final class Some3 {}

/**
 * Trait
 */
trait Some4 {}

/**
 * Interface
 */
interface Some5 {}

/**
 * Enum
 */
enum Some6 {}
