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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Commenting\MagicMethodSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class MagicMethodSniffTest extends SniffTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getSniffClass(): string
    {
        return MagicMethodSniff::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/magic-method/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/magic-method/wrong.php',
                [
                    'message' => 'The method __construct must contain only "Constructor." comment on first line.',
                    'source'  => 'FiveLab.Commenting.MagicMethod.WrongFormat',
                ],
                [
                    'message' => 'The method __construct must contain only "Constructor." comment on first line.',
                    'source'  => 'FiveLab.Commenting.MagicMethod.WrongFormat',
                ],
            ],
        ];
    }
}
