<?php

class MyException extends \SomeException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function foo(): string
    {
        $a = 1;

        // Some comment here
        return parent::foo();
    }

    public function bar()
    {
        parent::bar();

        $a = 1;
        $b = 2;
    }

    public function some()
    {
        $result = parent::some();

        return $result;
    }
}
