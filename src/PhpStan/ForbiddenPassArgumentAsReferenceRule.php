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

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node>
 */
class ForbiddenPassArgumentAsReferenceRule implements Rule
{
    /**
     * @var class-string<Node>
     */
    private string $nodeType;

    /**
     * Constructor.
     *
     * @param class-string<Node> $nodeType
     */
    public function __construct(string $nodeType)
    {
        if (!\is_a($nodeType, Node\Stmt\Function_::class, true) && !\is_a($nodeType, Node\Stmt\ClassMethod::class, true)) {
            throw new \InvalidArgumentException(\sprintf(
                'Invalid node type "%s". Support only %s or %s.',
                $nodeType,
                Node\Stmt\Function_::class,
                Node\Stmt\ClassMethod::class
            ));
        }

        $this->nodeType = $nodeType;
    }

    public function getNodeType(): string
    {
        return $this->nodeType;
    }

    /**
     * {@inheritdoc}
     *
     * @param Node\Stmt\Function_|Node\Stmt\ClassMethod $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        foreach ($node->getParams() as $param) {
            if ($param->byRef) {
                return [
                    RuleErrorBuilder::message('Pass arguments by reference is forbidden.')
                        ->identifier('passArguments.byReference')
                        ->build(),
                ];
            }
        }

        return [];
    }
}
