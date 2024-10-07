<?php

readonly class Some
{
    public function __construct()
    {
    }
}

readonly class Some
{
    public function __construct(private Foo $foo)
    {
    }
}

readonly class Some
{
    public function __construct(private Foo $foo, private Bar $bar)
    {
    }
}

readonly class Some
{
    public function __construct(
        private Foo $foo,
        private Bar $bar,
        private Baz $baz
    ) {
    }
}
