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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\MultiLineSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class MultiLineSniffTest extends SniffTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getSniffClass(): string
    {
        return MultiLineSniff::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/multi-line/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/multi-line/wrong.php',
                [
                    'message' => 'Multi line is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLine.WrongFormat',
                ],
                [
                    'message' => 'Multi line is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLine.WrongFormat',
                ],
                [
                    'message' => 'Multi line is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLine.WrongFormat',
                ],
                [
                    'message' => 'Multi line is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLine.WrongFormat',
                ],
                [
                    'message' => 'Multi line is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLine.WrongFormat',
                ],
                [
                    'message' => 'Multi line is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLine.WrongFormat',
                ],
                [
                    'message' => 'Multi line is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLine.WrongFormat',
                ],
            ],
        ];
    }
}
