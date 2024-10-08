<?php

readonly class Some
{
    public function __construct()
    {
    }
}

readonly class Some
{
    public function __construct(private Bar $bar)
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

readonly class Some
{
    public function __construct(#[Attribute(min: 1, max: 2)] private Foo $foo)
    {
    }
}
