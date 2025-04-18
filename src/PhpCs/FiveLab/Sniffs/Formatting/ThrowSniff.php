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
use FiveLab\Component\CiRules\PhpCs\FiveLab\PhpCsUtils;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Check throw errors.
 */
class ThrowSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_THROW,
        ];
    }

    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        // Check blank lines before
        $prevTokenPtr = $phpcsFile->findPrevious(Tokens::$emptyTokens, $stackPtr - 1, null, true);

        $prevToken = $phpcsFile->getTokens()[$prevTokenPtr];
        $diffLinesBefore = PhpCsUtils::getDiffLines($phpcsFile, (int) $prevTokenPtr, $stackPtr);

        $possiblePrevTokens = [T_OPEN_CURLY_BRACKET, T_COLON, T_COALESCE, T_MATCH_ARROW, T_INLINE_ELSE, T_FN_ARROW];

        if (!\in_array($prevToken['code'], $possiblePrevTokens, true) && $diffLinesBefore < 2) {
            $phpcsFile->addError(
                'Must be one blank line before throw exceptions.',
                $stackPtr,
                ErrorCodes::MISSED_LINE_BEFORE
            );
        }

        $this->checkSprintfOnSameLine($phpcsFile, $stackPtr);
    }

    /**
     * Check for make message with sprintf on same line.
     *
     * @param File $phpcsFile
     * @param int  $stackPtr
     */
    private function checkSprintfOnSameLine(File $phpcsFile, int $stackPtr): void
    {
        $openParenthesisPtr = $phpcsFile->findNext([T_OPEN_PARENTHESIS], $stackPtr + 1, null, false, null, true);

        if (!$openParenthesisPtr) {
            return;
        }

        $endOfMessagePtr = $phpcsFile->findNext([T_COMMA, T_SEMICOLON], $openParenthesisPtr);
        $sprintfTokenPtr = $phpcsFile->findNext([], $openParenthesisPtr, (int) $endOfMessagePtr, true, 'sprintf', true);

        if ($sprintfTokenPtr) {
            $tokens = $phpcsFile->getTokens();

            if ($tokens[$stackPtr]['line'] !== $tokens[$sprintfTokenPtr]['line']) {
                $phpcsFile->addError(
                    'The message for exception with use sprintf must be on same line what `throw`.',
                    $stackPtr,
                    ErrorCodes::WRONG_FORMAT
                );
            }
        }
    }
}
