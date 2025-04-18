<?php

// phpcs:ignore
# phpcs:ignore
public function foo(): void
{
    // comment
    # comment
}

class Some
{
    # @phpstan-ignore-line
    public function foo(): void // @phpstan-ignore-line
    {
        // comment
        # comment

        $d = 1; // comment
        $d = 3; # comment

        $r = static function (): void {
            $e = 3; // comment
            $e = 4; # comment
        };
    }

}
