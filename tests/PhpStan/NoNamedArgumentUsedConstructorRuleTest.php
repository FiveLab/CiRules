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

use FiveLab\Component\CiRules\PhpStan\NoNamedArgumentUsedConstructorRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class NoNamedArgumentUsedConstructorRuleTest extends RuleTestCase
{
    private NoNamedArgumentUsedConstructorRule $rule;

    protected function getRule(): Rule
    {
        return $this->rule;
    }

    #[Test]
    #[DataProvider('provideDataForTesting')]
    public function shouldSuccessProcess(array $methods, array $errors): void
    {
        $this->rule = new NoNamedArgumentUsedConstructorRule(...$methods);

        $this->analyse([__DIR__.'/Resources/no-named-argument-used-new.php'], [...$errors]);
    }

    public static function provideDataForTesting(): array
    {
        return [
            [
                ['DOMDocument'],
                [
                    ['The method "DOMDocument::__construct" is forbidden to call without named arguments.', 3],
                ],
            ],
        ];
    }
}
