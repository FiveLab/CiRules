<?php

class Some
{
    private Some $bar;

    private Some $foo;
}

class Some
{

    /**
     * @var string|int
     */
    private mixed $bar;
}

class Some
{

    /**
     * @var string|int
     */
    private mixed $bar;
    private mixed $foo;
}

class Some
{
    private mixed $bar;
    public function __construct()
    {
    }
}

class Some
{
    /**
     * Some comment
     */
    private const string A = 'A';
    private const string G = 'G';

    private const int bar = 8;
    public function __construct()
    {
    }
}
