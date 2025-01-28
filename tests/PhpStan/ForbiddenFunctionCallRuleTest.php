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

use FiveLab\Component\CiRules\PhpStan\ForbiddenFunctionCallRule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ForbiddenFunctionCallRuleTest extends RuleTestCase
{
    private ForbiddenFunctionCallRule $rule;

    protected function getRule(): ForbiddenFunctionCallRule
    {
        return $this->rule;
    }

    #[Test]
    #[DataProvider('provideDataForProcess')]
    public function shouldSuccessProcess(array $functions, array $errors): void
    {
        $this->rule = new ForbiddenFunctionCallRule(...$functions);

        $this->analyse([__DIR__.'/Resources/forbidden-functions.php'], [...$errors]);
    }

    public static function provideDataForProcess(): array
    {
        return [
            [
                ['curl_init', 'curl_exec'],
                [
                    ['The function "curl_init" is forbidden for usage.', 9],
                    ['The function "curl_exec" is forbidden for usage.', 11],
                ],
            ],

            [
                ['\\SomeNamespace\\func'],
                [
                    ['The function "SomeNamespace\func" is forbidden for usage.', 5],
                ],
            ],
        ];
    }
}
