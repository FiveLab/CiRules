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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\WhiteSpaceAroundControlStatementSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\AbstractSniffTestCase;

class WhiteSpaceAroundControlStatementSniffTest extends AbstractSniffTestCase
{
    protected function getSniffClass(): string
    {
        return WhiteSpaceAroundControlStatementSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/white-space-around-control-statement/success.php',
            ],

            'success match' => [
                __DIR__.'/Resources/white-space-around-control-statement/success-match.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/white-space-around-control-statement/wrong.php',
                [
                    'message' => 'Must be one blank line before "if" statement.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundControlStatement.MissedLineBefore',
                ],
                [
                    'message' => 'Must be one blank line after close "foreach" statement.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundControlStatement.MissedLineAfter',
                ],
            ],
        ];
    }
}
