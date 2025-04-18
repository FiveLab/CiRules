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

use FiveLab\Component\CiRules\PhpStan\ForbiddenMethodCallRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ForbiddenMethodCallRuleTest extends RuleTestCase
{
    private ForbiddenMethodCallRule $rule;

    protected function getRule(): Rule
    {
        return $this->rule;
    }

    #[Test]
    #[DataProvider('provideDataForTesting')]
    public function shouldSuccessProcess(array $methods, array $errors): void
    {
        $this->rule = new ForbiddenMethodCallRule(...$methods);

        $this->analyse([__DIR__.'/Resources/forbidden-methods.php'], [...$errors]);
    }

    public static function provideDataForTesting(): array
    {
        return [
            [
                ['DOMDocument'],
                [
                    ['Any method call from "DOMDocument" is forbidden.', 4],
                    ['Any method call from "DOMDocument" is forbidden.', 5],
                ],
            ],

            [
                ['SplFileInfo::getPath'],
                [
                    ['The method "SplFileInfo::getPath" is forbidden to call.', 8],
                ],
            ],
        ];
    }
}
