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
use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Sniff for check existence blank line after multiline call.
 *
 * <code>
 *      -> HERE MUST BE EMPTY BLANK LINE
 *      $object->callToMethod(
 *          $arg1,
 *          $arg2,
 *          $arg3,
 *          (1 + 2)
 *      );
 *      -> HERE MUST BE EMPTY BLANK LINE.
 * </code>
 */
class WhiteSpaceAroundMultilineCallSniff extends AbstractFunctionCallSniff
{
    protected function processFunctionCall(File $phpcsFile, int $stackPtr, array $parenthesisPtrs): void
    {
        [$parenthesisOpener, $parenthesisCloser] = $parenthesisPtrs;

        $multilines = PhpCsUtils::getDiffLines($phpcsFile, $parenthesisOpener, $parenthesisCloser);

        if ($multilines) {
            // Check one white space before and after.
            $this->checkBeforeCall($phpcsFile, $stackPtr);
            $this->checkAfterCall($phpcsFile, $parenthesisCloser);
        }
    }

    private function checkBeforeCall(File $phpcsFile, int $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $prevTokenPtr = $phpcsFile->findPrevious(Tokens::$emptyTokens, $stackPtr - 1, null, true);

        $possiblePrevTokens = [T_DOUBLE_COLON, T_COMMA];

        if (false !== $prevTokenPtr && \in_array($tokens[$prevTokenPtr]['code'], $possiblePrevTokens, true)) {
            // Chain call.
            return;
        }

        // Find any token on prev line.
        $firstTokenPtrOnLine = PhpCsUtils::findFirstTokenOnLine($phpcsFile, $tokens[$stackPtr]['line']);
        $prevTokenPtr = $phpcsFile->findPrevious(Tokens::$emptyTokens, $firstTokenPtrOnLine - 1, null, true);

        if (false !== $prevTokenPtr) {
            $prevToken = $tokens[$prevTokenPtr];

            if ($prevToken['code'] === T_VARIABLE) {
                // Call method on next line (multiline chain call).
                $prevTokenPtr = (int) $phpcsFile->findPrevious(Tokens::$emptyTokens, $prevTokenPtr - 1, null, true);
                $prevToken = $tokens[$prevTokenPtr];
            }

            $diffLines = PhpCsUtils::getDiffLines($phpcsFile, $prevTokenPtr, (int) $firstTokenPtrOnLine);

            $possiblePrevTokens = [
                T_COMMA,
                T_OPEN_CURLY_BRACKET,
                T_OPEN_PARENTHESIS,
                T_CLOSE_PARENTHESIS,
                T_OPEN_SHORT_ARRAY,
                T_COLON,
                T_ATTRIBUTE_END,
                T_RETURN
            ];

            if ($diffLines < 2 && !\in_array($prevToken['code'], $possiblePrevTokens, true)) {
                $phpcsFile->addError(
                    'Must be one blank line before multiline call.',
                    $prevTokenPtr,
                    ErrorCodes::MISSED_LINE_BEFORE
                );
            }
        }
    }

    private function checkAfterCall(File $phpcsFile, int $closeParenthesisPtr): void
    {
        $tokens = $phpcsFile->getTokens();

        $nextTokenPtr = $phpcsFile->findNext([T_WHITESPACE], $closeParenthesisPtr + 1, null, true);
        $possibleTypesAfterCloseParenthesis = [T_COMMA, T_OBJECT_OPERATOR, T_CLOSE_PARENTHESIS];

        if ($nextTokenPtr && \in_array($tokens[$nextTokenPtr]['code'], $possibleTypesAfterCloseParenthesis, true)) {
            // Chain calls.
            return;
        }

        $semicolonPtr = $phpcsFile->findNext([T_SEMICOLON], $closeParenthesisPtr + 1);
        $nextTokenPtr = $phpcsFile->findNext([T_WHITESPACE], $semicolonPtr + 1, null, true);

        if ($nextTokenPtr) {
            $nextToken = $tokens[$nextTokenPtr];
            $diffLines = PhpCsUtils::getDiffLines($phpcsFile, (int) $semicolonPtr, $nextTokenPtr);

            $possibleNextTokens = [T_CLOSE_CURLY_BRACKET, T_BREAK];

            if ($diffLines < 2 && !\in_array($nextToken['code'], $possibleNextTokens, true)) {
                $phpcsFile->addError(
                    'Must be one blank line after multiline call.',
                    $nextTokenPtr,
                    ErrorCodes::MISSED_LINE_AFTER
                );
            }
        }
    }
}
