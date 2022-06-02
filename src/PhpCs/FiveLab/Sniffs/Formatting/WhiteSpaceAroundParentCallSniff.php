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
use FiveLab\Component\CiRules\PhpCs\FiveLab\PhpCsUtils;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Check white spaced around `parent::method()` calls.
 */
class WhiteSpaceAroundParentCallSniff implements Sniff
{
    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_PARENT,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $this->processBefore($phpcsFile, $stackPtr);
        $this->processAfter($phpcsFile, $stackPtr);
    }

    /**
     * Process after
     *
     * @param File $phpcsFile
     * @param int  $stackPtr
     */
    private function processAfter(File $phpcsFile, int $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();

        $semicolonPtr = $phpcsFile->findNext([T_SEMICOLON], $stackPtr + 1);

        $nextTokenPtr = $phpcsFile->findNext(Tokens::$emptyTokens, $semicolonPtr + 1, null, true);

        if ($tokens[$nextTokenPtr]['code'] === T_CLOSE_CURLY_BRACKET) {
            // End statement. Normal.
            return;
        }

        $diffLines = PhpCsUtils::getDiffLines($phpcsFile, (int) $semicolonPtr, (int) $nextTokenPtr);

        if ($diffLines < 2) {
            $phpcsFile->addError(
                'Must be one blank line after `parent` call.',
                $stackPtr,
                ErrorCodes::MISSED_LINE_AFTER
            );
        }
    }

    /**
     * Process before
     *
     * @param File $phpcsFile
     * @param int  $stackPtr
     */
    private function processBefore(File $phpcsFile, int $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        $firstTokenOnLine = PhpCsUtils::findFirstTokenOnLine($phpcsFile, $token['line']);
        $prevTokenPtr = $phpcsFile->findPrevious(Tokens::$emptyTokens, (int) $firstTokenOnLine, null, true);

        if ($tokens[$prevTokenPtr]['code'] === T_OPEN_CURLY_BRACKET) {
            // Start statement. Normal.
            return;
        }

        $diffLines = PhpCsUtils::getDiffLines($phpcsFile, (int) $prevTokenPtr, $stackPtr);

        if ($diffLines < 2) {
            $phpcsFile->addError(
                'Must be one blank line before `parent` call.',
                $stackPtr,
                ErrorCodes::MISSED_LINE_BEFORE
            );
        }
    }
}
