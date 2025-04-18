<?php

// comment
# comment
public function foo(): void {}

// comment
class Some
{
    // comment
    private string $foo; // comment

    # comment
    private string $foo2; # comment

    // comment
    public function foo(): void // comment
    {}

    # comment
    public function bar(): void # comment
    {}
}
