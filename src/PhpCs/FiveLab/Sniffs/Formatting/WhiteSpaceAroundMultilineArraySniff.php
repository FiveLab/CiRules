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
 * Check what exist one blank line before and after multiline array creation.
 */
class WhiteSpaceAroundMultilineArraySniff implements Sniff
{
    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_CLOSE_SHORT_ARRAY,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $semicolonPtr = $phpcsFile->findNext(Tokens::$emptyTokens, $stackPtr + 1, null, true);

        if (!$semicolonPtr || $tokens[$semicolonPtr]['code'] !== T_SEMICOLON) {
            // Not close root array. Skip.
            return;
        }

        $openerTokenPtr = $tokens[$stackPtr]['bracket_opener'];

        $openerLineNumber = $tokens[$openerTokenPtr]['line'];
        $closerLineNumber = $tokens[$stackPtr]['line'];

        if ($closerLineNumber === $openerLineNumber) {
            // Single line array. Skip.
            return;
        }

        // Check before.
        $firstTokenOnOpenerLinePtr = PhpCsUtils::findFirstTokenOnLine($phpcsFile, $tokens[$openerTokenPtr]['line']);

        $prevTokenPtr = $phpcsFile->findPrevious(Tokens::$emptyTokens, $firstTokenOnOpenerLinePtr - 1, null, true);
        $prevToken = $tokens[$prevTokenPtr];

        $diffLinesBefore = PhpCsUtils::getDiffLines($phpcsFile, (int) $prevTokenPtr, (int) $firstTokenOnOpenerLinePtr);
        $possiblePrevTokens = [T_COLON, T_OPEN_CURLY_BRACKET];

        if (!\in_array($prevToken['code'], $possiblePrevTokens, true) && $diffLinesBefore < 2) {
            $phpcsFile->addError(
                'Must be one blank line before multiline array creation.',
                $openerTokenPtr,
                ErrorCodes::MISSED_LINE_BEFORE
            );
        }

        // Check after
        $nextTokenPtr = $phpcsFile->findNext(Tokens::$emptyTokens, $semicolonPtr + 1, null, true);

        if ($nextTokenPtr) {
            $nextToken = $tokens[$nextTokenPtr];
            $diffLinesAfter = PhpCsUtils::getDiffLines($phpcsFile, $semicolonPtr, $nextTokenPtr);
            $possibleNextTokens = [T_CLOSE_CURLY_BRACKET, T_BREAK];

            if (!\in_array($nextToken['code'], $possibleNextTokens, true) && $diffLinesAfter < 2) {
                $phpcsFile->addError(
                    'Must be one blank line after multiline array creation.',
                    $semicolonPtr,
                    ErrorCodes::MISSED_LINE_AFTER
                );
            }
        }
    }
}
