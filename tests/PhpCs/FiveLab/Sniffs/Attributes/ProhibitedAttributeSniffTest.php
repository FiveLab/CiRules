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

namespace FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\Attributes;

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Attributes\ProhibitedAttributeSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class ProhibitedAttributeSniffTest extends SniffTestCase
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
        $this->ruleset->sniffs[$this->getSniffClass()]->attributes = 'ProhibitedAttribute';

        parent::shouldSuccessProcessFile($file, ...$expectedErrors);
    }

    protected function getSniffClass(): string
    {
        return ProhibitedAttributeSniff::class;
    }

    public function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/prohibited-attribute/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/prohibited-attribute/wrong.php',
                [
                    'message' => 'Prohibited attribute.',
                    'source'  => 'FiveLab.Attributes.ProhibitedAttribute.Prohibited',
                ],
                [
                    'message' => 'Prohibited attribute.',
                    'source'  => 'FiveLab.Attributes.ProhibitedAttribute.Prohibited',
                ],
                [
                    'message' => 'Prohibited attribute.',
                    'source'  => 'FiveLab.Attributes.ProhibitedAttribute.Prohibited',
                ],
            ],
        ];
    }
}
