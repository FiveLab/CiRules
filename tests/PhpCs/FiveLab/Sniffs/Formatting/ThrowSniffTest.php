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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\ThrowSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class ThrowSniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return ThrowSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/throw/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/throw/wrong.php',
                [
                    'message' => 'Must be one blank line before throw exceptions.',
                    'source'  => 'FiveLab.Formatting.Throw.MissedLineBefore',
                ],
                [
                    'message' => 'The message for exception with use sprintf must be on same line what `throw`.',
                    'source'  => 'FiveLab.Formatting.Throw.WrongFormat',
                ],
            ],
        ];
    }
}
