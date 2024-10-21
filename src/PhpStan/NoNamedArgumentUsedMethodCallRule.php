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

namespace FiveLab\Component\CiRules\PhpStan;

use FiveLab\Component\CiRules\PhpStan\AbstractNoNamedArgumentUsedRule;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Type\ObjectType;

/**
 * No named for method call
 */
class NoNamedArgumentUsedMethodCallRule extends AbstractNoNamedArgumentUsedRule
{
    public function getNodeType(): string
    {
        return Node\Expr\MethodCall::class;
    }

    /**
     * {@inheritdoc}
     *
     * @param Node\Expr\MethodCall $node
     */
    protected function getClassName(Node $node, Scope $scope): ?string
    {
        $varType = $scope->getType($node->var);

        if ($varType instanceof ObjectType) {
            $varClassReflection = $varType->getClassReflection();

            if ($varClassReflection) {
                return $varClassReflection->getName();
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     *
     * @param Node\Expr\MethodCall $node
     */
    protected function getMethodName(Node $node): string
    {
        return $node->name->toString();
    }
}
