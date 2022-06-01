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

namespace FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\Commenting;

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Commenting\CommentSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class CommentSniffTest extends SniffTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getSniffClass(): string
    {
        return CommentSniff::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/comment/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/comment/wrong.php',
                [
                    'message' => 'The method or function must contain comment. Please add short description.',
                    'source'  => 'FiveLab.Commenting.Comment.MissingFunctionComment',
                    'line'    => 8,
                ],
                [
                    'message' => 'The method or function must contain comment. Please add short description.',
                    'source'  => 'FiveLab.Commenting.Comment.MissingFunctionComment',
                    'line'    => 14,
                ],
                [
                    'message' => 'Between end comment/notations and close comment tag can\'t be blank lines.',
                    'source'  => 'FiveLab.Commenting.Comment.WrongFormat',
                ],
                [
                    'message' => 'Must be one blank line between comment and annotations.',
                    'source'  => 'FiveLab.Commenting.Comment.MissedLineAfter',
                ],
                [
                    'message' => 'Previously must be a comment and after annotations.',
                    'source'  => 'FiveLab.Commenting.Comment.WrongFormat',
                ],
            ],
        ];
    }
}
