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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\WhiteSpaceAroundMultilineArraySniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class WhiteSpaceAroundMultilineArraySniffTest extends SniffTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getSniffClass(): string
    {
        return WhiteSpaceAroundMultilineArraySniff::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/white-space-around-multiline-array/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/white-space-around-multiline-array/wrong.php',
                [
                    'message' => 'Must be one blank line before multiline array creation.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundMultilineArray.MissedLineBefore',
                ],
                [
                    'message' => 'Must be one blank line after multiline array creation.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAroundMultilineArray.MissedLineAfter',
                ],
            ],
        ];
    }
}
