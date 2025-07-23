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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\ManySpacesSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class ManySpacesSniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return ManySpacesSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/many-spaces/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/many-spaces/wrong.php',
                [
                    'message' => 'Too many spaces. Must be one space.',
                    'source'  => 'FiveLab.Formatting.ManySpaces.ManySpaces',
                    'line'    => 3,
                ],
                [
                    'message' => 'Too many spaces. Must be one space.',
                    'source'  => 'FiveLab.Formatting.ManySpaces.ManySpaces',
                    'line'    => 4,
                ],
                [
                    'message' => 'Too many spaces. There must be no space before a semicolon.',
                    'source'  => 'FiveLab.Formatting.ManySpaces.ManySpaces',
                    'line'    => 5,
                ],
                [
                    'message' => 'Too many spaces. Must be one space.',
                    'source'  => 'FiveLab.Formatting.ManySpaces.ManySpaces',
                    'line'    => 7,
                ],
                [
                    'message' => 'Too many spaces. Must be one space.',
                    'source'  => 'FiveLab.Formatting.ManySpaces.ManySpaces',
                    'line'    => 8,
                ],
                [
                    'message' => 'Too many spaces. Must be one space.',
                    'source'  => 'FiveLab.Formatting.ManySpaces.ManySpaces',
                    'line'    => 9,
                ],
                [
                    'message' => 'Too many spaces. Must be one space.',
                    'source'  => 'FiveLab.Formatting.ManySpaces.ManySpaces',
                    'line'    => 10,
                ],
                [
                    'message' => 'Too many spaces. Must be one space.',
                    'source'  => 'FiveLab.Formatting.ManySpaces.ManySpaces',
                    'line'    => 11,
                ],
                [
                    'message' => 'Too many spaces. Must be one space.',
                    'source'  => 'FiveLab.Formatting.ManySpaces.ManySpaces',
                    'line'    => 12,
                ],
                [
                    'message' => 'Too many spaces. Must be one space.',
                    'source'  => 'FiveLab.Formatting.ManySpaces.ManySpaces',
                    'line'    => 13,
                ],
                [
                    'message' => 'Too many spaces. Must be one space.',
                    'source'  => 'FiveLab.Formatting.ManySpaces.ManySpaces',
                    'line'    => 14,
                ],
                [
                    'message' => 'Too many spaces. Must be one space.',
                    'source'  => 'FiveLab.Formatting.ManySpaces.ManySpaces',
                    'line'    => 17,
                ],
                [
                    'message' => 'Too many spaces. Must be one space.',
                    'source'  => 'FiveLab.Formatting.ManySpaces.ManySpaces',
                    'line'    => 20,
                ],
            ],
        ];
    }
}
