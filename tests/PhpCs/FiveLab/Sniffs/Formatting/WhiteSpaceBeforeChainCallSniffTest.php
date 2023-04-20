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

namespace FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\Formatting;

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\WhiteSpaceBeforeChainCallSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class WhiteSpaceBeforeChainCallSniffTest extends SniffTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getSniffClass(): string
    {
        return WhiteSpaceBeforeChainCallSniff::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/white-space-before-chain-call/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/white-space-before-chain-call/wrong.php',
                [
                    'message' => 'Must be 4 whitespaces before chain call.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceBeforeChainCall.WrongFormat',
                ],
                [
                    'message' => 'Must be 4 whitespaces before chain call.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceBeforeChainCall.WrongFormat',
                ],
                [
                    'message' => 'Must be 0 or 4 whitespaces before chain call.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceBeforeChainCall.WrongFormat',
                ],
                [
                    'message' => 'Must be 0 or 4 or 8 whitespaces before chain call.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceBeforeChainCall.WrongFormat',
                ],
                [
                    'message' => 'Must be 4 whitespaces before chain call.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceBeforeChainCall.WrongFormat',
                ],
                [
                    'message' => 'Must be 3 or 7 whitespaces before chain call.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceBeforeChainCall.WrongFormat',
                ],
                [
                    'message' => 'Must be 2 or 6 whitespaces before chain call.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceBeforeChainCall.WrongFormat',
                ],
            ],
        ];
    }
}
