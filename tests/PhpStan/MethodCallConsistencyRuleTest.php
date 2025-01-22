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

use FiveLab\Component\CiRules\PhpStan\MethodCallConsistencyRule;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Testing\PHPStanTestCase;
use PHPStan\Testing\RuleTestCase;

class MethodCallConsistencyRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $reflectionProvider = PHPStanTestCase::getContainer()->getByType(ReflectionProvider::class);

        return new MethodCallConsistencyRule($reflectionProvider);
    }

    /**
     * @test
     */
    public function shouldSuccessProcessForIsset(): void
    {
        $this->analyse(
            [__DIR__.'/Resources/MethodCallConsistency/ClassForProperty.php'],
            [
                ['Method "FiveLab\Component\CiRules\Tests\PhpStan\Resources\MethodCallConsistency\Example::instanceMethod" is not static but called statically.', 26],
                ['Method "FiveLab\Component\CiRules\Tests\PhpStan\Resources\MethodCallConsistency\Example->staticMethod" is static but called dynamically.', 27],
                ['Method "FiveLab\Component\CiRules\Tests\PhpStan\Resources\MethodCallConsistency\ClassForProperty::instanceMethod1" is not static but called statically.', 29],
                ['Method "FiveLab\Component\CiRules\Tests\PhpStan\Resources\MethodCallConsistency\ClassForProperty->staticMethod1" is static but called dynamically.', 30],
                ['Method "FiveLab\Component\CiRules\Tests\PhpStan\Resources\MethodCallConsistency\ClassForProperty::instanceMethod1" is not static but called statically.', 36],
                ['Method "FiveLab\Component\CiRules\Tests\PhpStan\Resources\MethodCallConsistency\ClassForProperty->staticMethod1" is static but called dynamically.', 37],
                ['Method "FiveLab\Component\CiRules\Tests\PhpStan\Resources\MethodCallConsistency\ClassForProperty::instanceMethod1" is not static but called statically.', 40],
            ],
        );
    }
}
