<?php

declare(strict_types = 1);

/**
 * This file is part of the FiveLab CiRules package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting;

use FiveLab\Component\CiRules\PhpCs\FiveLab\ErrorCodes;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ReadonlySniff implements Sniff
{
    const SCOPES = [
        T_PRIVATE,
        T_PROTECTED,
        T_PUBLIC,
    ];

    public function register(): array
    {
        return [
            T_READONLY,
        ];
    }

    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $readonly = $phpcsFile->getTokens()[$stackPtr];

        if ('readonly' !== $readonly['content']) {
            return;
        }

        $prev = $phpcsFile->getTokens()[$stackPtr - 2];
        $next = $phpcsFile->getTokens()[$stackPtr + 2];

        if (!\in_array($prev['code'], self::SCOPES, true) && \in_array($next['code'], self::SCOPES, true)) {
            $phpcsFile->addError(
                'Scope should be declared before readonly keyword.',
                $stackPtr,
                ErrorCodes::WRONG_FORMAT
            );
        }
    }
}
