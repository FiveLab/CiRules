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

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Abstract sniff for check function calls.
 */
abstract class AbstractFunctionCallSniff implements Sniff
{
    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return Tokens::$functionNameTokens;
    }

    /**
     * {@inheritdoc}
     */
    final public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $ignoreTokens = Tokens::$emptyTokens;
        $ignoreTokens[] = T_BITWISE_AND;

        $specialKeywordPtr = $phpcsFile->findPrevious($ignoreTokens, $stackPtr - 1, null, true);
        $specialKeywordCodes = [T_FUNCTION, T_CLASS, T_INTERFACE, T_TRAIT, T_ATTRIBUTE];

        if ($specialKeywordPtr && \in_array($tokens[$specialKeywordPtr]['code'], $specialKeywordCodes, true)) {
            // Declare special construction (function, class, etc...)
            return;
        }

        $openParenthesisPtr = $phpcsFile->findNext(Tokens::$emptyTokens, $stackPtr + 1, null, true);

        if (!$openParenthesisPtr || $tokens[$openParenthesisPtr]['code'] !== T_OPEN_PARENTHESIS) {
            return;
        }

        $openParenthesis = $tokens[$openParenthesisPtr];

        if (!$openParenthesis['parenthesis_closer']) {
            return;
        }

        $parenthesisPtrs = [$openParenthesisPtr, $openParenthesis['parenthesis_closer']];

        $this->processFunctionCall($phpcsFile, $stackPtr, $parenthesisPtrs);
    }

    /**
     * Process function call
     *
     * @param File       $phpcsFile
     * @param int        $stackPtr
     * @param array<int> $parenthesisPtrs
     */
    abstract protected function processFunctionCall(File $phpcsFile, int $stackPtr, array $parenthesisPtrs): void;
}
