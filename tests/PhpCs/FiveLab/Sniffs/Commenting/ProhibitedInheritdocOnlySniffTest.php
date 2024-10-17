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

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Commenting\ProhibitedInheritdocOnlySniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class ProhibitedInheritdocOnlySniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return ProhibitedInheritdocOnlySniff::class;
    }

    public function provideDataSet(): array
    {
        return [
            'success' => [
                __DIR__.'/Resources/prohibited-inheritdoc-only/success.php',
            ],

            'wrong' => [
                __DIR__.'/Resources/prohibited-inheritdoc-only/wrong.php',
                [
                    'message' => 'Prohibited {@inheritdoc} only comment.',
                    'source'  => 'FiveLab.Commenting.ProhibitedInheritdocOnly.Prohibited',
                ],
            ],
        ];
    }
}
