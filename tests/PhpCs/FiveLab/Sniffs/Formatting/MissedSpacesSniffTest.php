<?php

declare(strict_types = 1);

/*
 * This file is part of the FiveLab CiRules package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\Formatting;

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\MissedSpacesSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class MissedSpacesSniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return MissedSpacesSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/missed-spaces/success.php',
            ],

            'missed' => [
                __DIR__.'/Resources/missed-spaces/wrong.php',
                [
                    'message' => 'Missed one space before logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 7,
                ],
                [
                    'message' => 'Missed one space after logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 7,
                ],
                [
                    'message' => 'Missed one space after logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 8,
                ],
                [
                    'message' => 'Missed one space before logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 9,
                ],
                [
                    'message' => 'Missed one space before logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 11,
                ],
                [
                    'message' => 'Missed one space after logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 11,
                ],
                [
                    'message' => 'Missed one space after logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 12,
                ],
                [
                    'message' => 'Missed one space before logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 13,
                ],
                [
                    'message' => 'Missed one space before logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 15,
                ],
                [
                    'message' => 'Missed one space after logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 15,
                ],
                [
                    'message' => 'Missed one space before logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 16,
                ],
                [
                    'message' => 'Missed one space before logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 16,
                ],
                [
                    'message' => 'Missed one space after logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 18,
                ],
                [
                    'message' => 'Missed one space before logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 19,
                ],
                [
                    'message' => 'Missed one space after logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 21,
                ],
                [
                    'message' => 'Missed one space before logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 21,
                ],
                [
                    'message' => 'Missed one space before logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 22,
                ],
                [
                    'message' => 'Missed one space after logical operand.',
                    'source'  => 'FiveLab.Formatting.MissedSpaces.MissedSpace',
                    'line'    => 23,
                ],
            ],

        ];
    }
}
