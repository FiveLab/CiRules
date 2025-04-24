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
use PHPStan\Type\UnionType;

/**
 * @implements Rule<Node>
 */
readonly class FunctionStrictModeRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Expr\FuncCall::class;
    }

    /**
     * {@inheritdoc}
     *
     * @param Node\Expr\FuncCall $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node->name instanceof Node\Name) {
            return [];
        }

        $funcName = $node->name->toString();

        if ('in_array' !== $funcName) {
            return [];
        }

        if (!$node->args[0] instanceof Node\Arg || !$node->args[1] instanceof Node\Arg) {
            return [];
        }

        $isThreeArgs = 3 === \count($node->args);
        $needleType = $scope->getType($node->args[0]->value);
        $isNeedleScalarType = $this->isSafeToCompareNonStrict($needleType);

        if ($isThreeArgs && !$node->args[2] instanceof Node\Arg) {
            return [];
        }

        if (!$isThreeArgs && $isNeedleScalarType) {
            return [
                RuleErrorBuilder::message('The function in_array must be used in strict mode.')
                    ->identifier('functionCall.strictMode')
                    ->build(),
            ];
        }

        if ($isThreeArgs) {
            $modeType = $scope->getType($node->args[2]->value);

            if ($isNeedleScalarType && $modeType->isFalse()->yes()) {
                return [
                    RuleErrorBuilder::message('The function in_array must be used in strict mode.')
                        ->identifier('functionCall.strictMode')
                        ->build(),
                ];
            }

            if (!$isNeedleScalarType && $modeType->isTrue()->yes()) {
                return [
                    RuleErrorBuilder::message('You don\'t need to use strict mode when comparison objects.')
                        ->identifier('functionCall.strictMode')
                        ->build(),
                ];
            }
        }

        return [];
    }

    private function isSafeToCompareNonStrict(Type $argType): bool
    {
        if ($argType->isObject()->yes()) {
            return false;
        }

        if ($argType->isArray()->yes()) {
            $valueType = $argType->getIterableValueType();

            if ($valueType->isObject()->yes()) {
                return false;
            }

            if ($valueType instanceof UnionType) {
                $types = $valueType->getTypes();

                foreach ($types as $type) {
                    if ($type->isScalar()->no()) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
}
