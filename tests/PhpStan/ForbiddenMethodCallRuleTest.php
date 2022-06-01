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

use FiveLab\Component\CiRules\PhpStan\ForbiddenMethodCallRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class ForbiddenMethodCallRuleTest extends RuleTestCase
{
    /**
     * @var ForbiddenMethodCallRule
     */
    private ForbiddenMethodCallRule $rule;

    /**
     * {@inheritdoc}
     */
    protected function getRule(): Rule
    {
        return $this->rule;
    }

    /**
     * @test
     *
     * @param array $methods
     * @param array $errors
     *
     * @dataProvider provideDataForTesting
     */
    public function shouldSuccessProcess(array $methods, array $errors): void
    {
        $this->rule = new ForbiddenMethodCallRule(...$methods);

        $this->analyse([__DIR__.'/Resources/forbidden-methods.php'], [...$errors]);
    }

    /**
     * Provide data for testing
     *
     * @return array
     */
    public function provideDataForTesting(): array
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
