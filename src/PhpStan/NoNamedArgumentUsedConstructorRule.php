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

class NoNamedArgumentUsedConstructorRule extends AbstractNoNamedArgumentUsedRule
{
    public function __construct(string ...$classes)
    {
        $methods = \array_map(static function (string $className): string {
            return \sprintf('%s::__construct', $className);
        }, $classes);

        parent::__construct(...$methods);
    }

    public function getNodeType(): string
    {
        return Node\Expr\New_::class;
    }

    /**
     * {@inheritdoc}
     *
     * @param Node\Expr\New_ $node
     */
    protected function resolveNodeType(Node $node, Scope $scope): ?Type
    {
        if ($node->class instanceof Node\Name) {
            return $scope->getType($node);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     *
     * @param Node\Expr\New_ $node
     */
    protected function getMethodName(Node $node): string
    {
        return '__construct';
    }
}
