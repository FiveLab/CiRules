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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\TypehintSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\AbstractSniffTestCase;

class TypehintSniffTest extends AbstractSniffTestCase
{
    protected function getSniffClass(): string
    {
        return TypehintSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/typehint/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/typehint/wrong.php',
                [
                    'message' => 'Missed function parameter type.',
                    'source'  => 'FiveLab.Formatting.Typehint.MissedFunctionParameterType',
                ],
                [
                    'message' => 'Missed function parameter type.',
                    'source'  => 'FiveLab.Formatting.Typehint.MissedFunctionParameterType',
                ],
                [
                    'message' => 'Missed function parameter type.',
                    'source'  => 'FiveLab.Formatting.Typehint.MissedFunctionParameterType',
                ],
                [
                    'message' => 'Missed function return type.',
                    'source'  => 'FiveLab.Formatting.Typehint.MissedFunctionReturnType',
                ],
                [
                    'message' => 'Missed function parameter type.',
                    'source'  => 'FiveLab.Formatting.Typehint.MissedFunctionParameterType',
                ],
                [
                    'message' => 'Missed function return type.',
                    'source'  => 'FiveLab.Formatting.Typehint.MissedFunctionReturnType',
                ],
            ],
        ];
    }
}
