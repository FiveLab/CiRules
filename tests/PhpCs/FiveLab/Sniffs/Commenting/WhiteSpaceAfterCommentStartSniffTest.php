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

namespace FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\Commenting;

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Commenting\WhiteSpaceAfterCommentStartSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class WhiteSpaceAfterCommentStartSniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return WhiteSpaceAfterCommentStartSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/white-space-after-comment-start/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/white-space-after-comment-start/wrong.php',
                [
                    'message' => 'Must be one space after open comment.',
                    'source'  => 'FiveLab.Commenting.WhiteSpaceAfterCommentStart.WrongFormat',
                ],
            ],
        ];
    }
}
