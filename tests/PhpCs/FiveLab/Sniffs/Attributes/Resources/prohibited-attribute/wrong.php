<?php

class MyClass
{
    #[\ProhibitedAttribute]
    public function myMethod()
    {
    }
}

class MyClass
{
    #[\ProhibitedAttribute()]
    public function myMethod()
    {
    }
}


class MyClass
{
    #[\Acme\ProhibitedAttribute()]
    public function myMethod()
    {
    }
}
