<?php

declare(strict_types = 1);

/**
 * This file is part of the FiveLab CiRules package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\Formatting;

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\WhiteSpaceAroundClassPropertySniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class WhiteSpaceAroundClassPropertySniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return WhiteSpaceAroundClassPropertySniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/white-space-around-class-property/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/white-space-around-class-property/wrong.php',
                [
                    'message' => 'Line before class property is not allowed.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundClassProperty.LineBeforeNotAllowed',
                ],
                [
                    'message' => 'Line before class property is not allowed.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundClassProperty.LineBeforeNotAllowed',
                ],
                [
                    'message' => 'Must be one blank line after class property or const.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundClassProperty.MissedLineAfter',
                ],
                [
                    'message' => 'Must be one blank line before class property.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundClassProperty.MissedLineBefore',
                ],
            ],
        ];
    }
}
