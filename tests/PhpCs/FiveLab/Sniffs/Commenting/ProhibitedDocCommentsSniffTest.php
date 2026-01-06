<?php

declare(strict_types = 1);

/*
 * This file is part of the FiveLab CiRules package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\Commenting;

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Commenting\ProhibitedDocCommentsSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\AbstractSniffTestCase;

class ProhibitedDocCommentsSniffTest extends AbstractSniffTestCase
{
    protected function getSniffClass(): string
    {
        return ProhibitedDocCommentsSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/prohibited-doc-comments/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/prohibited-doc-comments/wrong.php',
                [
                    'message' => 'PHPDoc must contain at least one meta tag like @param, @return, etc.',
                    'source'  => 'FiveLab.Commenting.ProhibitedDocComments.PhpDocNotAllowed',
                ],
                [
                    'message' => 'PHPDoc must contain at least one meta tag like @param, @return, etc.',
                    'source'  => 'FiveLab.Commenting.ProhibitedDocComments.PhpDocNotAllowed',
                ],
                [
                    'message' => 'PHPDoc must contain at least one meta tag like @param, @return, etc.',
                    'source'  => 'FiveLab.Commenting.ProhibitedDocComments.PhpDocNotAllowed',
                ],
                [
                    'message' => 'PHPDoc must contain at least one meta tag like @param, @return, etc.',
                    'source'  => 'FiveLab.Commenting.ProhibitedDocComments.PhpDocNotAllowed',
                ],
                [
                    'message' => 'PHPDoc must contain at least one meta tag like @param, @return, etc.',
                    'source'  => 'FiveLab.Commenting.ProhibitedDocComments.PhpDocNotAllowed',
                ],
            ],
        ];
    }
}
