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
 * @implements Rule<Node\Expr\FuncCall>
 */
class ForbiddenFunctionCallRule implements Rule
{
    /**
     * @var array<string>
     */
    private array $forbiddenFunctions;

    /**
     * Constructor.
     *
     * @param string ...$forbiddenFunctions
     */
    public function __construct(string ...$forbiddenFunctions)
    {
        $this->forbiddenFunctions = \array_map(static function (string $function) {
            if ($function[0] === '\\') {
                $function = \substr($function, 1);
            }

            return $function;
        }, $forbiddenFunctions);
    }

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
        $funcName = $node->name->toString();

        if (\in_array($funcName, $this->forbiddenFunctions, true)) {
            return [
                RuleErrorBuilder::message(\sprintf('The function "%s" is forbidden for usage.', $funcName))
                    ->identifier('functionCall.forbidden')
                    ->build(),
            ];
        }

        return [];
    }
}
