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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\WhiteSpaceAroundMultilineCallSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class WhiteSpaceAroundMultilineCallSniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return WhiteSpaceAroundMultilineCallSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/white-space-around-multiline-call/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/white-space-around-multiline-call/wrong.php',
                [
                    'message' => 'Must be one blank line before multiline call.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundMultilineCall.MissedLineBefore',
                ],
                [
                    'message' => 'Must be one blank line after multiline call.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundMultilineCall.MissedLineAfter',
                ],
                [
                    'message' => 'Must be one blank line before multiline call.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundMultilineCall.MissedLineBefore',
                ],
                [
                    'message' => 'Must be one blank line after multiline call.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundMultilineCall.MissedLineAfter',
                ],
            ],
        ];
    }
}
