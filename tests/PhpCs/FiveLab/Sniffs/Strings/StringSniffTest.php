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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Strings\StringSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class StringSniffTest extends SniffTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getSniffClass(): string
    {
        return StringSniff::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/string/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/string/wrong.php',
                [
                    'message' => 'Use double quotes is forbidden.',
                    'source'  => 'FiveLab.Strings.String.DoubleQuotes',
                ],
                [
                    'message' => 'Use double quotes is forbidden.',
                    'source'  => 'FiveLab.Strings.String.DoubleQuotes',
                ],
                [
                    'message' => 'Use double quotes is forbidden.',
                    'source'  => 'FiveLab.Strings.String.DoubleQuotes',
                ],
            ],
        ];
    }
}
