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

namespace FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\Strings;

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Strings\AsciiSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class AsciiSniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return AsciiSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'wrong' => [
                __DIR__.'/Resources/ascii/wrong.php',
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 209, 208, 209, 209, 209, 208, 208, 209, 209, 208, 208"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 208, 208, 208"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 208, 208, 209, 209"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 208, 208, 208, 208, 208, 208, 208, 208"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 208, 208, 209, 208, 208, 208, 208"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 208, 209, 208, 208, 208, 208, 208, 208, 209"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 209, 208, 208, 208, 209"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 209, 209, 208, 208, 208, 208, 208, 208, 209, 208, 208, 208, 209, 208, 209, 208, 208"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 208, 208, 209, 209"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 208, 208, 208, 208, 208, 209, 208, 209, 208, 208"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 208, 209, 208, 208"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 208, 209, 209"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 208, 209, 208, 209, 209, 208, 208, 209"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 209, 208, 208, 209"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
                [
                    'message' => 'Use not ASCII printable symbols is forbidden: "208, 208, 209, 208, 208"',
                    'source'  => 'FiveLab.Strings.Ascii.Prohibited',
                ],
            ],
        ];
    }
}
