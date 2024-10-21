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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\WhiteSpaceAfterOpenerSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class WhiteSpaceAfterOpenerSniffTest extends SniffTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getSniffClass(): string
    {
        return WhiteSpaceAfterOpenerSniff::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/white-space-after-opener/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/white-space-after-opener/wrong.php',
                [
                    'message' => 'Line after opener is not allowed.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAfterOpener.LineAfterNotAllowed',
                ],
                [
                    'message' => 'Line after opener is not allowed.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAfterOpener.LineAfterNotAllowed',
                ],
                [
                    'message' => 'Line after opener is not allowed.',
                    'source'  => 'FiveLab.Formatting.WhiteSpaceAfterOpener.LineAfterNotAllowed',
                ],
            ],
        ];
    }
}
