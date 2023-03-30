<?php

declare(strict_types = 1);

/*
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
 * Check the multi line.
 */
class MultiLineSniff implements Sniff
{
    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_ELSEIF,
            T_FOR,
            T_FOREACH,
            T_IF,
            T_WHILE,
            T_INLINE_THEN,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $stmt = $tokens[$stackPtr];

        if (T_INLINE_THEN === $stmt['code']) {
            $equalPtr = $phpcsFile->findPrevious(T_EQUAL, $stackPtr);
            $returnPtr = $phpcsFile->findPrevious(T_RETURN, $stackPtr);
            $semiPtr = $phpcsFile->findNext(T_SEMICOLON, $stackPtr);

            $startLine = $tokens[\max($equalPtr, $returnPtr)]['line'];
            $endLine = $tokens[$semiPtr]['line'];
        } else {
            $startLine = $stmt['line'];
            $endLine = $tokens[$stmt['parenthesis_closer']]['line'];
        }

        if ($startLine !== $endLine) {
            $phpcsFile->addError(
                'Multi line is not allowed.',
                $stackPtr,
                ErrorCodes::WRONG_FORMAT
            );
        }
    }
}
