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
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\AbstractSniffTestCase;

class UnusedImportsSniffTest extends AbstractSniffTestCase
{
    protected function getSniffClass(): string
    {
        return UnusedImportsSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'success: var namespace' => [
                __DIR__.'/Resources/unused-imports/success-var-namespace.php',
            ],

            'success: property' => [
                __DIR__.'/Resources/unused-imports/success-prop.php',
            ],

            'success: argument' => [
                __DIR__.'/Resources/unused-imports/success-arg.php',
            ],

            'success: doc-throws' => [
                __DIR__.'/Resources/unused-imports/success-doc-throws.php',
            ],

            'success: doc-class-string' => [
                __DIR__.'/Resources/unused-imports/success-doc-class-string.php',
            ],

            'success: doc-annotation' => [
                __DIR__.'/Resources/unused-imports/success-doc-annotation.php',
            ],

            'success: doc-return' => [
                __DIR__.'/Resources/unused-imports/success-doc-return.php',
            ],

            'success: doc-implements' => [
                __DIR__.'/Resources/unused-imports/success-doc-implements.php',
            ],

            'success: combined' => [
                __DIR__.'/Resources/unused-imports/success-combined.php',
            ],

            'success: with alias' => [
                __DIR__.'/Resources/unused-imports/success-with-alias.php',
            ],

            'unused' => [
                __DIR__.'/Resources/unused-imports/unused.php',
                [
                    'message' => 'Unused import: Bar.',
                    'source'  => 'FiveLab.Formatting.UnusedImports.Unused',
                ],
                [
                    'message' => 'Unused import: Bazz.',
                    'source'  => 'FiveLab.Formatting.UnusedImports.Unused',
                ],
            ],
        ];
    }
}
