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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\DeclareSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class DeclareSniffTest extends SniffTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getSniffClass(): string
    {
        return DeclareSniff::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/declare/success.php',
            ],

            'missed' => [
                __DIR__.'/Resources/declare/missed.php',
                [
                    'message' => 'Missed declare statement.',
                    'source'  => 'FiveLab.Formatting.Declare.Missed',
                ],
            ],

            'wrong: without spaces' => [
                __DIR__.'/Resources/declare/wrong-01.php',
                [
                    'message' => 'Wrong declare tag (strict_types=1). Add a single space around assignment operators or trim spaces around.',
                    'source'  => 'FiveLab.Formatting.Declare.WrongFormat',
                ],
            ],

            'wrong: without space on right side' => [
                __DIR__.'/Resources/declare/wrong-02.php',
                [
                    'message' => 'Wrong declare tag (strict_types =1). Add a single space around assignment operators or trim spaces around.',
                    'source'  => 'FiveLab.Formatting.Declare.WrongFormat',
                ],
            ],

            'wrong: multiple' => [
                __DIR__.'/Resources/declare/wrong-03.php',
                [
                    'message' => 'Wrong declare tag (strict_types = 1,ticks = 1). Must be one space after comma.',
                    'source'  => 'FiveLab.Formatting.Declare.WrongFormat',
                ],
            ],

            'wrong: missed lines before and after' => [
                __DIR__.'/Resources/declare/wrong-04.php',
                [
                    'message' => 'Must be one blank line before declaration.',
                    'source'  => 'FiveLab.Formatting.Declare.MissedLineAfter',
                ],
                [
                    'message' => 'Must be one blank line before declaration.',
                    'source'  => 'FiveLab.Formatting.Declare.MissedLineBefore',
                ],
            ],
        ];
    }
}
