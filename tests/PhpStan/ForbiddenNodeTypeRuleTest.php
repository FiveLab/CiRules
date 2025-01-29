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

use FiveLab\Component\CiRules\PhpStan\ForbiddenNodeTypeRule;
use PhpParser\Node\Expr\Empty_;
use PhpParser\Node\Expr\Isset_;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class ForbiddenNodeTypeRuleTest extends RuleTestCase
{
    private ForbiddenNodeTypeRule $rule;

    protected function getRule(): Rule
    {
        return $this->rule;
    }

    /**
     * @test
     */
    public function shouldSuccessProcessForIsset(): void
    {
        $this->rule = new ForbiddenNodeTypeRule(Isset_::class, 'Language construct isset() should not be used.');

        $this->analyse(
            [__DIR__.'/Resources/forbidden-node-type.php'],
            [
                ['Language construct isset() should not be used.', 3],
            ],
        );
    }

    /**
     * @test
     */
    public function shouldSuccessProcessForEmpty(): void
    {
        $this->rule = new ForbiddenNodeTypeRule(Empty_::class, 'Language construct empty() should not be used.');

        $this->analyse(
            [__DIR__.'/Resources/forbidden-node-type.php'],
            [
                ['Language construct empty() should not be used.', 4],
            ]
        );
    }

    /**
     * @test
     */
    public function shouldThrowErrorForInvalidNodeType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The node type class must implement "PhpParser\Node" interface but "FooBar" got given.');

        new ForbiddenNodeTypeRule('FooBar');
    }
}
