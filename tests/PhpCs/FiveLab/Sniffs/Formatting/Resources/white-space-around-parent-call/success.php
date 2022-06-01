<?php

class MyException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string
    {
        $a = 1;

        // Some comment here
        return parent::__toString();
    }

    public function __wakeup()
    {
        parent::__wakeup();

        $a = 1;
        $b = 2;
    }
}
