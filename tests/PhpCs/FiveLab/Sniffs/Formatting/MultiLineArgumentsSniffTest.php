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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\MultiLineArgumentsSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class MultiLineArgumentsSniffTest extends SniffTestCase
{
    /**
     * @test
     *
     * @param string       $file
     * @param array<array> ...$expectedErrors
     *
     * @dataProvider provideDataSet
     */
    public function shouldSuccessProcessFile(string $file, array ...$expectedErrors): void
    {
        $onlyInOneLine = (int) \substr($file, -5, 1);
        $this->ruleset->sniffs[$this->getSniffClass()]->onlyInOneLine = $onlyInOneLine;

        parent::shouldSuccessProcessFile($file, ...$expectedErrors);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSniffClass(): string
    {
        return MultiLineArgumentsSniff::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideDataSet(): array
    {
        return [
            'success 0' => [
                __DIR__.'/Resources/multi-line-arguments/success-0.php',
            ],

            'success 1' => [
                __DIR__.'/Resources/multi-line-arguments/success-1.php',
            ],

            'success 2' => [
                __DIR__.'/Resources/multi-line-arguments/success-2.php',
            ],

            'wrong 0' => [
                __DIR__.'/Resources/multi-line-arguments/wrong-0.php',
                [
                    'message' => 'Multi line empty constructor is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLineArguments.WrongFormat',
                ],
            ],

            'wrong 1' => [
                __DIR__.'/Resources/multi-line-arguments/wrong-1.php',
                [
                    'message' => 'Multi line empty constructor is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLineArguments.WrongFormat',
                ],
                [
                    'message' => 'Multi line for 1 arguments is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLineArguments.WrongFormat',
                ],
                [
                    'message' => 'Multi line for 1 arguments is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLineArguments.WrongFormat',
                ],
            ],

            'wrong 2' => [
                __DIR__.'/Resources/multi-line-arguments/wrong-2.php',
                [
                    'message' => 'Multi line empty constructor is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLineArguments.WrongFormat',
                ],
                [
                    'message' => 'Multi line for 1 arguments is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLineArguments.WrongFormat',
                ],
                [
                    'message' => 'Multi line for 2 arguments is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLineArguments.WrongFormat',
                ],
                [
                    'message' => 'Multi line for 2 arguments is not allowed.',
                    'source'  => 'FiveLab.Formatting.MultiLineArguments.WrongFormat',
                ],
            ],
        ];
    }
}
