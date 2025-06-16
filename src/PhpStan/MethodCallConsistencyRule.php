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
use PHPStan\Reflection\ExtendedMethodReflection;
use PHPStan\Reflection\MissingMethodFromReflectionException;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<Node>
 */
readonly class MethodCallConsistencyRule implements Rule
{
    public function __construct(private ReflectionProvider $reflectionProvider)
    {
    }

    public function getNodeType(): string
    {
        return Node\Expr::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($node instanceof Node\Expr\StaticCall) {
            // parent::method()
            if ($node->class instanceof Node\Name && 'parent' === $node->class->toString()) {
                return $this->checkNativeMethodCall($node, $scope);
            }

            return $this->checkStaticCall($node, $scope);
        }

        if ($node instanceof Node\Expr\MethodCall) {
            return $this->checkInstanceCall($node, $scope);
        }

        return [];
    }

    /**
     * Check static method call
     *
     * @param Node\Expr\StaticCall $node
     * @param Scope                $scope
     *
     * @return list<IdentifierRuleError>
     *
     * @throws ShouldNotHappenException
     */
    private function checkStaticCall(Node\Expr\StaticCall $node, Scope $scope): array
    {
        $className = $this->resolveClassNameForStaticCall($node, $scope);

        if (!$className) {
            return [];
        }

        $methodReflection = $this->getMethodReflection($node, $className, $scope);

        if (!$methodReflection?->isStatic()) {
            return [
                RuleErrorBuilder::message(\sprintf(
                    'Method "%s::%s" is not static but called statically.',
                    $className,
                    $methodReflection?->getName()
                ))
                    ->identifier('methodCall.consistency')
                    ->build(),
            ];
        }

        return [];
    }

    /**
     * Check instance method call
     *
     * @param Node\Expr\MethodCall $node
     * @param Scope                $scope
     *
     * @return list<IdentifierRuleError>
     *
     * @throws ShouldNotHappenException
     */
    private function checkInstanceCall(Node\Expr\MethodCall $node, Scope $scope): array
    {
        $className = $this->resolveClassNameForInstanceCall($node, $scope);

        if (!$className) {
            return [];
        }

        $methodReflection = $this->getMethodReflection($node, $className, $scope);

        if ($methodReflection?->isStatic()) {
            return [
                RuleErrorBuilder::message(\sprintf(
                    'Method "%s->%s" is static but called dynamically.',
                    $className,
                    $methodReflection->getName()
                ))
                    ->identifier('methodCall.consistency')
                    ->build(),
            ];
        }

        return [];
    }

    /**
     * Check parent method call
     *
     * @param Node\Expr\StaticCall $node
     * @param Scope                $scope
     *
     * @return list<IdentifierRuleError>
     *
     * @throws ShouldNotHappenException|MissingMethodFromReflectionException
     */
    private function checkNativeMethodCall(Node\Expr\StaticCall $node, Scope $scope): array
    {
        $methodName = $node->name instanceof Node\Identifier ? $node->name->toString() : null;

        if (null === $methodName) {
            return [];
        }

        $classReflection = $scope->getClassReflection();

        if (null === $classReflection) {
            return [];
        }

        $method = $classReflection->getNativeMethod($methodName);

        if ($method->getDeclaringClass()->getName() !== $classReflection->getName()) {
            return [
                RuleErrorBuilder::message(\sprintf(
                    'Class "%s" has no native method "%s" but called statically from parent.',
                    $classReflection->getName(),
                    $methodName
                ))
                    ->identifier('methodCall.consistency')
                    ->build(),
            ];
        }

        return [];
    }

    private function resolveClassNameForStaticCall(Node\Expr\StaticCall $node, Scope $scope): ?string
    {
        // self::method()
        if ($node->class instanceof Node\Name && 'self' === $node->class->toString()) {
            return $scope->getClassReflection()?->getName();
        }

        // ClassName::method()
        if ($node->class instanceof Node\Name) {
            return $scope->resolveName($node->class);
        }

        // $this->property::method()
        if ($node->class instanceof Node\Expr\PropertyFetch) {
            $type = $scope->getType($node->class);

            if (\method_exists($type, 'getClassName') && $type->isObject()->yes()) {
                return $type->getClassName();
            }
        }

        // $var::method()
        if ($node->class instanceof Node\Expr\Variable) {
            $variableName = $node->class->name;

            if (\is_string($variableName)) {
                $type = $scope->getType(new Node\Expr\Variable($variableName));

                if (\method_exists($type, 'getClassName') && $type->isObject()->yes()) {
                    return $type->getClassName();
                }
            }
        }

        return null;
    }

    private function resolveClassNameForInstanceCall(Node\Expr\MethodCall $node, Scope $scope): ?string
    {
        // $this->method()
        if ($node->var instanceof Node\Expr\Variable && $node->var->name === 'this') {
            return $scope->getClassReflection()?->getName();
        }

        // $this->property->method()
        if ($node->var instanceof Node\Expr\PropertyFetch) {
            $type = $scope->getType($node->var);

            if (\method_exists($type, 'getClassName') && $type->isObject()->yes()) {
                return $type->getClassName();
            }
        }

        // $var->method()
        if ($node->var instanceof Node\Expr\Variable) {
            $variableName = $node->var->name;

            if (\is_string($variableName)) {
                $type = $scope->getType(new Node\Expr\Variable($variableName));

                if (\method_exists($type, 'getClassName') && $type->isObject()->yes()) {
                    return $type->getClassName();
                }
            }
        }

        return null;
    }

    private function getMethodReflection(Node\Expr\StaticCall|Node\Expr\MethodCall $node, string $className, Scope $scope): ?ExtendedMethodReflection
    {
        $methodName = $node->name instanceof Node\Identifier ? $node->name->name : null;

        if (!$className || !$methodName) {
            return null;
        }

        $classReflection = $this->reflectionProvider->getClass($className);

        if (!$classReflection->hasMethod($methodName)) {
            return null;
        }

        return $classReflection->getMethod($methodName, $scope);
    }
}
