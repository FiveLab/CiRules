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

use FiveLab\Component\CiRules\PhpStan\NoNamedArgumentUsedMethodCallRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class NoNamedArgumentUsedMethodCallRuleTest extends RuleTestCase
{
    private NoNamedArgumentUsedMethodCallRule $rule;

    protected function getRule(): Rule
    {
        return $this->rule;
    }

    #[Test]
    #[DataProvider('provideDataForTesting')]
    public function shouldSuccessProcess(array $methods, array $errors): void
    {
        $this->rule = new NoNamedArgumentUsedMethodCallRule(...$methods);

        $this->analyse([__DIR__.'/Resources/no-named-argument-used-method-call.php'], [...$errors]);
    }

    public static function provideDataForTesting(): array
    {
        return [
            [
                ['DOMDocument'],
                [
                    ['The method "DOMDocument::loadXML" is forbidden to call without named arguments.', 4],
                    ['The method "DOMDocument::loadHTML" is forbidden to call without named arguments.', 5],
                ],
            ],

            [
                ['SplFileInfo::openFile'],
                [
                    ['The method "SplFileInfo::openFile" is forbidden to call without named arguments.', 8],
                ],
            ],
        ];
    }
}
