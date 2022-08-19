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
 * Sniff for check existence one blank line around control statement.
 *
 * <code>
 *      -> HERE MUST BE EMPTY BLANK LINE.
 *      if ($condition) {
 *          // Some code here
 *      }
 *      -> HERE MUST BE EMPTY BLANK LINE.
 * </code>
 */
class WhiteSpaceAroundControlStatementSniff implements Sniff
{
    /**
     * @var array<array<string|int>>
     */
    private static array $ignoredTokens = [
        T_IF     => [T_ELSE, T_ELSEIF, T_COLON],
        T_ELSE   => [T_IF, T_CLOSE_CURLY_BRACKET],
        T_ELSEIF => [T_ELSEIF, T_CLOSE_CURLY_BRACKET, T_ELSE],
        T_DO     => [T_WHILE],
        T_WHILE  => [T_DO],
    ];

    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_IF,
            T_ELSE,
            T_ELSEIF,
            T_FOREACH,
            T_FOR,
            T_WHILE,
            T_DO,
            T_SWITCH,
            T_MATCH,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, $stackPtr): void
    {
        $stackToken = $phpcsFile->getTokens()[$stackPtr];

        if (!\array_key_exists('scope_closer', $stackToken)) {
            // Active token hasn't close scope. Maybe use "else if" (or similar) construction where scope undefined.
            return;
        }

        // Check blank lines before statement
        $prevTokenPtr = $phpcsFile->findPrevious(Tokens::$emptyTokens, $stackPtr - 1, null, true);
        $prevToken = $phpcsFile->getTokens()[$prevTokenPtr];

        if (($prevToken['code'] === T_EQUAL || $prevToken['code'] === T_RETURN) && $stackToken['code'] === T_MATCH) {
            // Use "match" construction.
            $firstTokenPtr = PhpCsUtils::findFirstTokenOnLine($phpcsFile, $stackToken['line']);
            $prevTokenPtr = $phpcsFile->findPrevious(Tokens::$emptyTokens, $firstTokenPtr - 1, null, true);
            $prevToken = $phpcsFile->getTokens()[$prevTokenPtr];
        }

        $diffLinesBefore = PhpCsUtils::getDiffLines($phpcsFile, (int) $prevTokenPtr, (int) $stackPtr);
        $shouldPrevIgnore = $this->shouldIgnore($stackToken, $prevToken);

        if ($prevToken['code'] !== T_OPEN_CURLY_BRACKET && !$shouldPrevIgnore && $diffLinesBefore < 2) {
            $phpcsFile->addError(
                \sprintf('Must be one blank line before "%s" statement.', $stackToken['content']),
                $stackPtr,
                ErrorCodes::MISSED_LINE_BEFORE
            );
        }

        // Check blank lines after
        $scopeCloserPtr = $stackToken['scope_closer'];
        $nextTokenPtr = $phpcsFile->findNext(Tokens::$emptyTokens, $scopeCloserPtr + 1, null, true);

        if ($nextTokenPtr) {
            $nextToken = $phpcsFile->getTokens()[$nextTokenPtr];

            if ($nextToken['code'] === T_SEMICOLON && $stackToken['code'] === T_MATCH) {
                // Use "match" construction.
                $nextTokenPtr = $phpcsFile->findNext(Tokens::$emptyTokens, $nextTokenPtr + 1, null, true);
                $nextToken = $nextTokenPtr ? $phpcsFile->getTokens()[$nextTokenPtr] : null;
            }

            if ($nextToken) {
                $diffLinesAfter = PhpCsUtils::getDiffLines($phpcsFile, $scopeCloserPtr, (int) $nextTokenPtr);
                $shouldNextIgnore = $this->shouldIgnore($stackToken, $nextToken);

                if ($nextToken['code'] !== T_CLOSE_CURLY_BRACKET && !$shouldNextIgnore && $diffLinesAfter < 2) {
                    $phpcsFile->addError(
                        \sprintf('Must be one blank line after close "%s" statement.', $stackToken['content']),
                        $scopeCloserPtr,
                        ErrorCodes::MISSED_LINE_AFTER
                    );
                }
            }
        }
    }

    /**
     * Should ignore?
     *
     * @param array<mixed> $stackToken
     * @param array<mixed> $prevToken
     *
     * @return bool
     */
    private function shouldIgnore(array $stackToken, array $prevToken): bool
    {
        if (\array_key_exists($stackToken['code'], self::$ignoredTokens)) {
            return \in_array($prevToken['code'], self::$ignoredTokens[$stackToken['code']], true);
        }

        return false;
    }
}
