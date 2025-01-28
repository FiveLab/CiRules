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
class ForbiddenNodeTypeRule implements Rule
{
    /**
     * @var class-string<Node>
     */
    private string $nodeType;

    private string $message;

    /**
     * Constructor.
     *
     * @param class-string<Node> $nodeType
     * @param string|null        $message
     */
    public function __construct(string $nodeType, string $message = null)
    {
        if (!\is_a($nodeType, Node::class, true)) { // @phpstan-ignore phpstanApi.runtimeReflection
            throw new \InvalidArgumentException(\sprintf(
                'The node type class must implement "%s" interface but "%s" got given.',
                Node::class,
                $nodeType
            ));
        }

        if (!$message) {
            $message = \sprintf(
                'The node "%s" is forbidden for usage.',
                $nodeType
            );
        }

        $this->nodeType = $nodeType;
        $this->message = $message;
    }

    public function getNodeType(): string
    {
        return $this->nodeType;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message($this->message)
                ->identifier('nodeCall.forbidden')
                ->build(),
        ];
    }
}
