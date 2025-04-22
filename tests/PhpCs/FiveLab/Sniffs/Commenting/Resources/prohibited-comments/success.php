<?php

/*
 * This file is part of the FiveLab CiRules package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace\bar\foo\;

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
