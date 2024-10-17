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

namespace FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\Whitespace;

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Whitespace\ManyWhitespacesSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class ManyWhitespacesSniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return ManyWhitespacesSniff::class;
    }

    public function provideDataSet(): array
    {
        return [
            [
                __DIR__.'/Resources/many-whitespaces/success.php',
            ],

            [
                __DIR__.'/Resources/many-whitespaces/wrong.php',
                [
                    'message' => 'More blank lines. Can\'t be more then one blank line between code/comment blocks.',
                    'source'  => 'FiveLab.Whitespace.ManyWhitespaces.Multiple',
                    'line'    => 7,
                ],
                [
                    'message' => 'More blank lines. Can\'t be more then one blank line between code/comment blocks.',
                    'source'  => 'FiveLab.Whitespace.ManyWhitespaces.Multiple',
                    'line'    => 11,
                ],
            ],
        ];
    }
}
