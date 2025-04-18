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

/**
 * Check constant typehint.
 */
class TypedConstantsSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_CONST,
        ];
    }

    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        if (PHP_VERSION_ID < 80300) {
            return;
        }

        $tokens = $phpcsFile->getTokens();

        if (T_STRING === $tokens[$stackPtr + 2]['code'] && T_STRING === $tokens[$stackPtr + 4]['code']) {
            return;
        }

        $phpcsFile->addError(
            'Missed constant type.',
            $stackPtr,
            ErrorCodes::MISSED_CONSTANT_TYPE
        );
    }
}
