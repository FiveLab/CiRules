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
use PHPStan\Type\Type;

/**
 * @implements Rule<Node>
 */
abstract class AbstractNoNamedArgumentUsedRule implements Rule
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

    /**
     * {@inheritdoc}
     *
     * @param Node\Expr\MethodCall|Node\Expr\New_ $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];

        foreach ($this->forbiddenMethods as $forbiddenClass => $forbiddenMethods) {
            $nodeType = $this->resolveNodeType($node, $scope);

            if ($nodeType && \in_array($forbiddenClass, $nodeType->getObjectClassNames(), true)) {
                $methodName = $this->getMethodName($node);

                if ('all' === $forbiddenMethods || \in_array(\strtolower($methodName), $forbiddenMethods, true)) {
                    if ($this->findNullableName($node)) {
                        $message = \sprintf(
                            'The method "%s::%s" is forbidden to call without named arguments.',
                            $nodeType->getObjectClassNames()[0],
                            $methodName
                        );

                        $errors[] = RuleErrorBuilder::message($message)
                            ->identifier('methodCall.withoutNamedArguments.forbidden')
                            ->build();
                    }
                }
            }
        }

        return $errors;
    }

    /**
     * Resolve node type in specific scope
     *
     * @param Node  $node
     * @param Scope $scope
     *
     * @return Type|null
     */
    abstract protected function resolveNodeType(Node $node, Scope $scope): ?Type;

    /**
     * Get method name
     *
     * @param Node $node
     *
     * @return string
     */
    abstract protected function getMethodName(Node $node): string;

    /**
     * Find nullable name
     *
     * @param Node\Expr\MethodCall|Node\Expr\New_ $node
     *
     * @return bool
     */
    private function findNullableName(Node $node): bool
    {
        $nullableNames = \array_filter($node->getArgs(), static function (Node\Arg $arg): bool {
            return null === $arg->name;
        });

        return \count($nullableNames) > 0;
    }
}
