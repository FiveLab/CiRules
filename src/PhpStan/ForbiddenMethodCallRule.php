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
use PHPStan\Type\ObjectType;

/**
 * @implements Rule<Node\Expr\MethodCall>
 */
class ForbiddenMethodCallRule implements Rule
{
    /**
     * @var array<mixed>
     */
    private array $forbiddenMethods;

    /**
     * Constructor.
     *
     * @param string ...$methods
     */
    public function __construct(string ...$methods)
    {
        $forbiddenMethods = [];

        foreach ($methods as $method) {
            @[$className, $methodName] = \explode('::', $method);

            if ($methodName) {
                if (!\array_key_exists($className, $forbiddenMethods)) {
                    $forbiddenMethods[$className] = [];
                }

                $forbiddenMethods[$className][] = \strtolower($methodName); // @phpstan-ignore-line
            } else {
                $forbiddenMethods[$className] = 'all';
            }
        }

        $this->forbiddenMethods = $forbiddenMethods;
    }

    public function getNodeType(): string
    {
        return Node\Expr\MethodCall::class;
    }

    /**
     * {@inheritdoc}
     *
     * @param Node\Expr\MethodCall $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];

        foreach ($this->forbiddenMethods as $forbiddenClass => $forbiddenMethods) {
            $varType = $scope->getType($node->var);

            if ($varType instanceof ObjectType) {
                $varClassReflection = $varType->getClassReflection();

                if ($varClassReflection && \is_a($varClassReflection->getName(), $forbiddenClass, true)) {
                    if ('all' === $forbiddenMethods) {
                        $errors[] = \sprintf(
                            'Any method call from "%s" is forbidden.',
                            $forbiddenClass
                        );
                    } elseif (\in_array($node->name->toLowerString(), $forbiddenMethods, true)) {
                        $errors[] = \sprintf(
                            'The method "%s::%s" is forbidden to call.',
                            $varClassReflection->getName(),
                            $node->name->toString()
                        );
                    }
                }
            }
        }

        return $errors;
    }
}
