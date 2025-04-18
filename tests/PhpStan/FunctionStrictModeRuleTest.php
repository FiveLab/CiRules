<?php

declare(strict_types = 1);

/**
 * This file is part of the FiveLab CiRules package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

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
                ['The function in_array must be used in strict mode.', 16],
                ['The function in_array must be used in strict mode.', 17],
                ['The function in_array must be used in strict mode.', 18],
                ['The function in_array must be used in strict mode.', 21],
                ['The function in_array must be used in strict mode.', 23],
            ],
        );
    }
}
