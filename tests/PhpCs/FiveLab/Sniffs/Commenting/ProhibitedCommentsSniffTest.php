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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Commenting\ProhibitedCommentsSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class ProhibitedCommentsSniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return ProhibitedCommentsSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/prohibited-comments/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/prohibited-comments/wrong.php',
                [
                    'message' => 'Simple comments who start with "//, #, /* " prohibited inside function bodies.',
                    'source'  => 'FiveLab.Commenting.ProhibitedComments.CommentOutsideFunctionBody',
                ],
                [
                    'message' => 'Simple comments who start with "//, #, /* " prohibited inside function bodies.',
                    'source'  => 'FiveLab.Commenting.ProhibitedComments.CommentOutsideFunctionBody',
                ],
                [
                    'message' => 'Simple comments who start with "//, #, /* " prohibited inside function bodies.',
                    'source'  => 'FiveLab.Commenting.ProhibitedComments.CommentOutsideFunctionBody',
                ],
                [
                    'message' => 'Simple comments who start with "//, #, /* " prohibited inside function bodies.',
                    'source'  => 'FiveLab.Commenting.ProhibitedComments.CommentOutsideFunctionBody',
                ],
                [
                    'message' => 'Simple comments who start with "//, #, /* " prohibited inside function bodies.',
                    'source'  => 'FiveLab.Commenting.ProhibitedComments.CommentOutsideFunctionBody',
                ],
                [
                    'message' => 'Simple comments who start with "//, #, /* " prohibited inside function bodies.',
                    'source'  => 'FiveLab.Commenting.ProhibitedComments.CommentOutsideFunctionBody',
                ],
                [
                    'message' => 'Simple comments who start with "//, #, /* " prohibited inside function bodies.',
                    'source'  => 'FiveLab.Commenting.ProhibitedComments.CommentOutsideFunctionBody',
                ],
                [
                    'message' => 'Simple comments who start with "//, #, /* " prohibited inside function bodies.',
                    'source'  => 'FiveLab.Commenting.ProhibitedComments.CommentOutsideFunctionBody',
                ],
                [
                    'message' => 'Simple comments who start with "//, #, /* " prohibited inside function bodies.',
                    'source'  => 'FiveLab.Commenting.ProhibitedComments.CommentOutsideFunctionBody',
                ],
                [
                    'message' => 'Simple comments who start with "//, #, /* " prohibited inside function bodies.',
                    'source'  => 'FiveLab.Commenting.ProhibitedComments.CommentOutsideFunctionBody',
                ],
                [
                    'message' => 'Simple comments who start with "//, #, /* " prohibited inside function bodies.',
                    'source'  => 'FiveLab.Commenting.ProhibitedComments.CommentOutsideFunctionBody',
                ],
            ],
        ];
    }
}
