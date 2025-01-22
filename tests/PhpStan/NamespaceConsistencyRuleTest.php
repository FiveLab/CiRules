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

use FiveLab\Component\CiRules\PhpStan\NamespaceConsistencyRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class NamespaceConsistencyRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NamespaceConsistencyRule();
    }

    /**
     * @test
     */
    public function shouldSuccessProcessForIsset(): void
    {
        $filePathError = __DIR__.'/Resources/NamespaceConsistencyRule/TestService.php';

        $this->analyse(
            [$filePathError, __DIR__.'/Resources/NamespaceConsistencyRule/ExampleService.php'],
            [
                ['Namespace mismatch in file "'.$filePathError.'". Expected namespace "FiveLab\Component\CiRules\Tests\PhpStan\Resources\NamespaceConsistencyRule", found "FiveLab\Component\CiRules\Tests".', 05],
            ],
        );
    }
}
