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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting\TypedConstantsSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class TypedConstantsSniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return TypedConstantsSniff::class;
    }

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
        if (PHP_VERSION_ID < 80300) {
            $this->markTestSkipped('Only for PHP >= 8.3.0.');
        }

        parent::shouldSuccessProcessFile($file, ...$expectedErrors);
    }

    public static function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/typed-constants/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/typed-constants/wrong.php',
                [
                    'message' => 'Missed constant type.',
                    'source'  => 'FiveLab.Formatting.TypedConstants.MissedConstantType',
                ],
            ],
        ];
    }
}
