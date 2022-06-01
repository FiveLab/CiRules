<?php

class FooBar implements \Stringable
{
    /**
     * Constructor.
     */
    public function __construct()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return 'foo';
    }
}
