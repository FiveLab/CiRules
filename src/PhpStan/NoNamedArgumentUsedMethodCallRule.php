<?php

declare(strict_types = 1);

/**
 * This file is part of the FiveLab CiRules package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\CiRules\PhpStan;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Type\Type;

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
    protected function resolveNodeType(Node $node, Scope $scope): ?Type
    {
        return $scope->getType($node->var);
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
