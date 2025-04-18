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

/**
 * Check the declaration strict types.
 */
class DeclareSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_OPEN_TAG,
        ];
    }

    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $declarePtr = $phpcsFile->findNext(T_DECLARE, $stackPtr);

        if (!$declarePtr) {
            $phpcsFile->addError(
                'Missed declare statement.',
                $stackPtr,
                ErrorCodes::MISSED
            );

            return;
        }

        $declareToken = $phpcsFile->getTokens()[$declarePtr];

        // Check formats
        $declareContent = PhpCsUtils::getContentsBetweenPtrs($phpcsFile, $declareToken['parenthesis_opener'] + 1, $declareToken['parenthesis_closer']);
        $declares = \explode(',', $declareContent);

        $processedFirst = false;

        foreach ($declares as $declare) {
            if ($processedFirst) {
                if ($declare[0] !== ' ') {
                    $phpcsFile->addError(
                        \sprintf('Wrong declare tag (%s). Must be one space after comma.', \implode(',', $declares)),
                        $declarePtr,
                        ErrorCodes::WRONG_FORMAT
                    );
                } else {
                    $declare = \substr($declare, 1);
                }
            }

            $processedFirst = $processedFirst ?: true;

            if (!\preg_match('/^\S+\s=\s\S+$/', $declare)) {
                $phpcsFile->addError(
                    \sprintf('Wrong declare tag (%s). Add a single space around assignment operators or trim spaces around.', $declare),
                    $declarePtr,
                    ErrorCodes::WRONG_FORMAT
                );
            }
        }

        // Check multiple declares
        $nextDeclare = $phpcsFile->findNext([T_DECLARE], $declareToken['parenthesis_closer']);

        if ($nextDeclare) {
            $phpcsFile->addError(
                'Multiple declares is prohibited.',
                $nextDeclare,
                ErrorCodes::MULTIPLE
            );
        }

        // Check one blank line after declare.
        $nextTokenPtr = $phpcsFile->findNext([T_WHITESPACE, T_SEMICOLON], $declareToken['parenthesis_closer'] + 1, null, true);

        if ($nextTokenPtr) {
            $blankLinesAfter = $phpcsFile->getTokens()[$nextTokenPtr]['line'] - ($declareToken['line'] + 1);

            if ($blankLinesAfter < 1) {
                $phpcsFile->addError(
                    'Must be one blank line before declaration.',
                    $nextTokenPtr,
                    ErrorCodes::MISSED_LINE_AFTER
                );
            }
        }

        // Check one blank line before declare
        $prevTokenPtr = $phpcsFile->findPrevious([T_WHITESPACE], $declarePtr - 1, null, true);

        if (false !== $prevTokenPtr) {
            $blankLinesBefore = ($declareToken['line'] - 1) - $phpcsFile->getTokens()[$prevTokenPtr]['line'];

            if ($blankLinesBefore < 1) {
                $phpcsFile->addError(
                    'Must be one blank line before declaration.',
                    $prevTokenPtr,
                    ErrorCodes::MISSED_LINE_BEFORE
                );
            }
        }
    }
}
