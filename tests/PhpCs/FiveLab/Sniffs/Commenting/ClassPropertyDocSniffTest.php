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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Commenting\ClassPropertyDocSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\AbstractSniffTestCase;

class ClassPropertyDocSniffTest extends AbstractSniffTestCase
{
    protected function getSniffClass(): string
    {
        return ClassPropertyDocSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/class-property-doc/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/class-property-doc/wrong.php',
                [
                    'message' => 'The annotation @var can\'t be on one line for class property. Please use multiline.',
                    'source'  => 'FiveLab.Commenting.ClassPropertyDoc.WrongFormat',
                ],
                [
                    'message' => 'The annotation @var can\'t be on one line for class property. Please use multiline.',
                    'source'  => 'FiveLab.Commenting.ClassPropertyDoc.WrongFormat',
                ],
                [
                    'message' => 'Please use vector type annotation for arrays.',
                    'source'  => 'FiveLab.Commenting.ClassPropertyDoc.ArraysDocVector',
                ],
            ],
        ];
    }
}
