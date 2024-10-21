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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\SemicolonSingleCharSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class SemicolonSingleCharSniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return SemicolonSingleCharSniff::class;
    }

    public function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/semicolon-single-char/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/semicolon-single-char/wrong.php',
                [
                    'message' => 'Close semicolon must be on one line with method/function call.',
                    'source'  => 'FiveLab.Formatting.SemicolonSingleChar.WrongFormat',
                ],
            ],
        ];
    }
}
