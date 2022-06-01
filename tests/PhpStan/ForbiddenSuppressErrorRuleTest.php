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

use FiveLab\Component\CiRules\PhpStan\ForbiddenSuppressErrorRule;
use PHPStan\Testing\RuleTestCase;

class ForbiddenSuppressErrorRuleTest extends RuleTestCase
{
    /**
     * @var ForbiddenSuppressErrorRule
     */
    private ForbiddenSuppressErrorRule $rule;

    /**
     * {@inheritdoc}
     */
    protected function getRule(): ForbiddenSuppressErrorRule
    {
        return $this->rule;
    }

    /**
     * @test
     *
     * @param array $allowed
     * @param array $errors
     *
     * @dataProvider provideDataForTesting
     */
    public function shouldSuccessProcess(array $allowed, array $errors): void
    {
        $this->rule = new ForbiddenSuppressErrorRule(...$allowed);

        $this->analyse([__DIR__.'/Resources/forbidden-suppress-error.php'], [...$errors]);
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
                ['trigger_error', 'DOMDocument::loadxml'],
                [
                    ['Suppress error is forbidden.', 13],
                    ['Suppress error is forbidden.', 15],
                ],
            ],
        ];
    }
}
