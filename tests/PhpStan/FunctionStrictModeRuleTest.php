<?php

/*
 * This file is part of the FiveLab CiRules package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

declare(strict_types = 1);

namespace FiveLab\Component\CiRules\Tests\PhpStan;

use FiveLab\Component\CiRules\PhpStan\FunctionStrictModeRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\Test;

class FunctionStrictModeRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new FunctionStrictModeRule();
    }

    #[Test]
    public function shouldSuccessProcess(): void
    {
        $this->analyse(
            [__DIR__.'/Resources/function-strict-mode.php'],
            [
                ['The function in_array must be used in strict mode.', 26],
                ['The function in_array must be used in strict mode.', 27],
                ['The function in_array must be used in strict mode.', 28],
                ['The function in_array must be used in strict mode.', 31],
                ['The function in_array must be used in strict mode.', 33],
                ['The function in_array must be used in strict mode.', 35],
                ['The function in_array must be used in strict mode.', 55],
            ],
        );
    }
}
