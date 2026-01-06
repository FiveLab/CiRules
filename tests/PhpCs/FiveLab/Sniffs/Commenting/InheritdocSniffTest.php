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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Commenting\InheritdocSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\AbstractSniffTestCase;

class InheritdocSniffTest extends AbstractSniffTestCase
{
    protected function getSniffClass(): string
    {
        return InheritdocSniff::class;
    }

    protected function isShouldIncludeFile(): bool
    {
        return true;
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/inheritdoc/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/inheritdoc/wrong.php',
                [
                    'message' => 'The notation {@inheritdoc} must be in lower case.',
                    'source'  => 'FiveLab.Commenting.Inheritdoc.WrongFormat',
                ],
                [
                    'message' => 'Must be one blank line before {@inheritdoc} notation.',
                    'source'  => 'FiveLab.Commenting.Inheritdoc.MissedLineBefore',
                ],
                [
                    'message' => 'Must be one blank line after {@inheritdoc} notation.',
                    'source'  => 'FiveLab.Commenting.Inheritdoc.MissedLineAfter',
                ],
                [
                    'message' => 'The notation {@inheritdoc} presented, but method "bar" does not declared in extended classes/interfaces.',
                    'source'  => 'FiveLab.Commenting.Inheritdoc.Missed',
                ],
            ],

            'wrong: without class' => [
                __DIR__.'/Resources/inheritdoc/wrong-without-class.php',
                [
                    'message' => 'The notation {@inheritdoc} presented for function "someMyFunction", but it not a method in class/interface.',
                    'source'  => 'FiveLab.Commenting.Inheritdoc.Missed',
                ],
            ],
        ];
    }
}
