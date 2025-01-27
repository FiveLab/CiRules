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

use FiveLab\Component\CiRules\PhpStan\ForbiddenPassArgumentAsReferenceRule;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PHPStan\Testing\RuleTestCase;

class ForbiddenPassArgumentAsReferenceRuleTest extends RuleTestCase
{
    private ForbiddenPassArgumentAsReferenceRule $rule;

    protected function getRule(): ForbiddenPassArgumentAsReferenceRule
    {
        return $this->rule;
    }

    /**
     * @test
     */
    public function shouldSuccessProcessForFunction(): void
    {
        $this->rule = new ForbiddenPassArgumentAsReferenceRule(Function_::class);

        $this->analyse(
            [__DIR__.'/Resources/forbidden-pass-arguments-as-reference.php'],
            [
                ['Pass arguments by reference is forbidden.', 7],
            ]
        );
    }

    /**
     * @test
     */
    public function shouldSuccessProcessForMethod(): void
    {
        $this->rule = new ForbiddenPassArgumentAsReferenceRule(ClassMethod::class);

        $this->analyse(
            [__DIR__.'/Resources/forbidden-pass-arguments-as-reference.php'],
            [
                ['Pass arguments by reference is forbidden.', 17],
            ]
        );
    }
}
