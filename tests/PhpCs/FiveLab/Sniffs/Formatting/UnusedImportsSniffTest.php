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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\UnusedImportsSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class UnusedImportsSniffTest extends SniffTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getSniffClass(): string
    {
        return UnusedImportsSniff::class;
    }

    /**
     * {@inheritdoc}
     */
    public function provideDataSet(): array
    {
        return [
            'success: property' => [
                __DIR__.'/Resources/unused-imports/success-prop.php',
            ],

            'success: argument' => [
                __DIR__.'/Resources/unused-imports/success-arg.php',
            ],

            'success: doc' => [
                __DIR__.'/Resources/unused-imports/success-doc.php',
            ],

            'unused' => [
                __DIR__.'/Resources/unused-imports/unused.php',
                [
                    'message' => 'Unused import: Bar.',
                    'source'  => 'FiveLab.Formatting.UnusedImports.Unused',
                ],
            ],
        ];
    }
}
