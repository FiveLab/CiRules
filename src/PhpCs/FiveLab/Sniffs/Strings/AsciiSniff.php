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

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Strings;

use FiveLab\Component\CiRules\PhpCs\FiveLab\ErrorCodes;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class AsciiSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_VARIABLE,
            T_CLASS,
            T_INTERFACE,
            T_FUNCTION,
            T_STRING,
            T_CONSTANT_ENCAPSED_STRING,
            T_DOUBLE_QUOTED_STRING,
            T_COMMENT,
            T_DOC_COMMENT_STRING,
        ];
    }

    public function process(File $phpcsFile, $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $content = $tokens[$stackPtr]['content'];
        $forbiddenSymbols = [];

        foreach (mb_str_split($content) as $char) {
            $ascii = ord($char);
            if (10 !== $ascii && (32 > $ascii || 127 < $ascii)) {
                $forbiddenSymbols[] = $ascii;
            }
        }

        if ($forbiddenSymbols) {
            $phpcsFile->addError(
                'Use not ASCII printable symbols is forbidden: "%s"',
                $stackPtr,
                ErrorCodes::PROHIBITED,
                [\implode(', ', $forbiddenSymbols)]
            );
        }
    }
}
