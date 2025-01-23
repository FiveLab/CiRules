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

namespace FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\Namespace;

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Namespace\NamespaceSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class NamespaceSniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return NamespaceSniff::class;
    }

    public function provideDataSet(): array
    {
        return [
            'wrong' => [
                __DIR__.'/Resources/TestService.php',
                [
                    'message' => 'Namespace mismatch in file "/code/tests/PhpCs/FiveLab/Sniffs/Namespace/Resources/TestService.php". Expected namespace "FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\Namespace\Resources", found " FiveLab\Component\CiRules\Tests".',
                    'source'  => 'FiveLab.Namespace.Namespace.NamespaceWrong',
                ],
            ],
        ];
    }
}
