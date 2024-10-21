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

/**
 * No named for new class
 */
class NoNamedArgumentUsedConstructorRule extends AbstractNoNamedArgumentUsedRule
{
    /**
     * Constructor.
     *
     * @param string ...$classes
     */
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
    protected function getClassName(Node $node, Scope $scope): ?string
    {
        if ($node->class instanceof Node\Name) {
            return $node->class->toString();
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
