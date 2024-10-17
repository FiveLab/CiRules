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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\ReadonlySniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class ReadonlySniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return ReadonlySniff::class;
    }

    public function provideDataSet(): array
    {
        return [
            'success: construct' => [
                __DIR__.'/Resources/readonly/success-construct.php',
            ],

            'success: property' => [
                __DIR__.'/Resources/readonly/success-property.php',
            ],

            'wrong: construct' => [
                __DIR__.'/Resources/readonly/wrong-construct.php',
                [
                    'message' => 'Scope should be declared before readonly keyword.',
                    'source'  => 'FiveLab.Formatting.Readonly.WrongFormat',
                ],
            ],

            'wrong: property' => [
                __DIR__.'/Resources/readonly/wrong-property.php',
                [
                    'message' => 'Scope should be declared before readonly keyword.',
                    'source'  => 'FiveLab.Formatting.Readonly.WrongFormat',
                ],
            ],
        ];
    }
}
