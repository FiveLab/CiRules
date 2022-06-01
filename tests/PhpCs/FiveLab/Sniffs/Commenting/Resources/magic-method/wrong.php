<?php

class FooBar
{
    /**
     * FooBar constructor.
     */
    public function __construct()
    {
    }
}

class BarFoo extends FooBar
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
    }
}
