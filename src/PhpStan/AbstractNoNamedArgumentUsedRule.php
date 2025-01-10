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
            $className = $this->getClassName($node, $scope);

            if (null !== $className && \is_a($className, $forbiddenClass, true)) {
                $methodName = $this->getMethodName($node);

                if ('all' === $forbiddenMethods || \in_array(\strtolower($methodName), $forbiddenMethods, true)) {
                    if ($this->findNullableName($node)) {
                        $errors[] = RuleErrorBuilder::message(\sprintf('The method "%s::%s" is forbidden to call without named arguments.', $className, $methodName))
                            ->identifier('method.call.without.named.arguments.forbidden')
                            ->build();
                    }
                }
            }
        }

        return $errors;
    }

    /**
     * Get class name
     *
     * @param Node  $node
     * @param Scope $scope
     *
     * @return null|string
     */
    abstract protected function getClassName(Node $node, Scope $scope): ?string;

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
