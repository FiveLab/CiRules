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
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ForbiddenSuppressErrorRuleTest extends RuleTestCase
{
    private ForbiddenSuppressErrorRule $rule;

    protected function getRule(): ForbiddenSuppressErrorRule
    {
        return $this->rule;
    }

    #[Test]
    #[DataProvider('provideDataForTesting')]
    public function shouldSuccessProcess(array $allowed, array $errors): void
    {
        $this->rule = new ForbiddenSuppressErrorRule(...$allowed);

        $this->analyse([__DIR__.'/Resources/forbidden-suppress-error.php'], [...$errors]);
    }

    public static function provideDataForTesting(): array
    {
        return [
            [
                ['trigger_error', 'DOMDocument::loadXML'],
                [
                    ['Suppress error is forbidden.', 13],
                    ['Suppress error is forbidden.', 15],
                ],
            ],
        ];
    }
}
