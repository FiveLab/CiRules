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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\WhiteSpaceAroundParentCallSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\AbstractSniffTestCase;

class WhiteSpaceAroundParentCallSniffTest extends AbstractSniffTestCase
{
    protected function getSniffClass(): string
    {
        return WhiteSpaceAroundParentCallSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/white-space-around-parent-call/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/white-space-around-parent-call/wrong.php',
                [
                    'message' => 'Must be one blank line before `parent` call.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundParentCall.MissedLineBefore',
                ],
                [
                    'message' => 'Must be one blank line before `parent` call.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundParentCall.MissedLineBefore',
                ],
                [
                    'message' => 'Must be one blank line after `parent` call.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundParentCall.MissedLineAfter',
                ],
            ],
        ];
    }
}
