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

namespace FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\Functions;

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Functions\GlobalFunctionsSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class GlobalFunctionsSniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return GlobalFunctionsSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/global-functions/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/global-functions/wrong.php',
                [
                    'message' => 'Must use NS separator (\) for global functions (sprintf).',
                    'source'  => 'FiveLab.Functions.GlobalFunctions.WrongFormat',
                ],
            ],
        ];
    }
}
