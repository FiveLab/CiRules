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
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\AbstractSniffTestCase;

class NamespaceSniffTest extends AbstractSniffTestCase
{
    protected function getSniffClass(): string
    {
        return NamespaceSniff::class;
    }

    public static function provideDataSet(): array
    {
        return [
            'wrong' => [
                __DIR__.'/Resources/TestService.php',
                [
                    'message' => 'Expected namespace "FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\Namespace\Resources", found " FiveLab\Component\CiRules\Tests".',
                    'source'  => 'FiveLab.Namespace.Namespace.NamespaceWrong',
                ],
            ],
        ];
    }
}
