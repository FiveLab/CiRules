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
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\List_;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;

/**
 * @implements Rule<Node\Expr\ErrorSuppress>
 */
class ForbiddenSuppressErrorRule implements Rule
{
    /**
     * @var array<string>
     */
    private array $allowedFunctions;

    /**
     * @var array<string, array<string>>
     */
    private array $allowedMethods;

    /**
     * Constructor.
     *
     * @param string ...$allowed
     */
    public function __construct(string ...$allowed)
    {
        $allowedFunctions = [];
        $allowedMethods = [];

        foreach ($allowed as $item) {
            $parts = \explode('::', $item, 2);

            if (\count($parts) === 1) {
                // Function
                $allowedFunctions[] = \strtolower($item);
            } else {
                // Method
                [$className, $methodName] = $parts;

                if (!\array_key_exists($className, $allowedMethods)) {
                    $allowedMethods[$className] = [];
                }

                $allowedMethods[$className][] = \strtolower($methodName);
            }
        }

        $this->allowedFunctions = $allowedFunctions;
        $this->allowedMethods = $allowedMethods;
    }

    public function getNodeType(): string
    {
        return Node\Expr\ErrorSuppress::class;
    }

    /**
     * {@inheritdoc}
     *
     * @param Node\Expr\ErrorSuppress $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->expr instanceof Assign && ($node->expr->var instanceof Array_ || $node->expr->var instanceof List_)) {
            return [];
        }

        if ($node->expr instanceof FuncCall && \in_array($node->expr->name->toLowerString(), $this->allowedFunctions, true)) {
            return [];
        }

        if ($node->expr instanceof MethodCall) {
            $variableType = $scope->getType($node->expr->var);

            if ($variableType instanceof ObjectType) {
                $varClassReflection = $variableType->getClassReflection();

                if ($varClassReflection) {
                    foreach ($this->allowedMethods as $allowedClass => $allowedMethods) {
                        if (\is_a($varClassReflection->getName(), $allowedClass, true) && \in_array($node->expr->name->toLowerString(), $allowedMethods, true)) {
                            return [];
                        }
                    }
                }
            }
        }

        return [
            RuleErrorBuilder::message('Suppress error is forbidden.')
                ->identifier('errorSuppress.forbidden')
                ->build(),
        ];
    }
}
