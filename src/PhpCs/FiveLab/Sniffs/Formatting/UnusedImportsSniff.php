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
 * Check the unused imports.
 */
class UnusedImportsSniff implements Sniff
{
    const CHARS_AROUND_USAGE = [
        '', ' ', '|', '&', '\\',
        '[', ']',
        '<', '>', ',',
        '@', '(', ')',
    ];

    const TOKENS_SEARCH_IN = [
        T_DOC_COMMENT_STRING,
        T_DOC_COMMENT_TAG,
        T_STRING,
    ];

    public function register(): array
    {
        return [
            T_USE,
        ];
    }

    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();

        if (1 !== $tokens[$stackPtr]['column'] || 0 !== $tokens[$stackPtr]['level']) {
            return;
        }

        $currentStackPtr = $phpcsFile->findNext(T_SEMICOLON, $stackPtr);

        $import = $tokens[$currentStackPtr - 1]['content'];

        $importStackPtr = $stackPtr;

        while ($currentStackPtr = $phpcsFile->findNext(T_USE, ++$currentStackPtr)) {
            if (1 === $tokens[$currentStackPtr]['column'] && 0 === $tokens[$currentStackPtr]['level']) {
                $importStackPtr = $currentStackPtr;
            }
        }

        $currentStackPtr = $phpcsFile->findNext(T_SEMICOLON, $importStackPtr);

        while ($currentStackPtr && $currentStackPtr = $phpcsFile->findNext(self::TOKENS_SEARCH_IN, ++$currentStackPtr)) {
            $token = $tokens[$currentStackPtr];

            $pos = false;

            for ($i = 0; $i < \substr_count($token['content'], $import); $i++) {
                $pos = \strpos($token['content'], $import, (int) $pos);

                $beforeChar = $pos === 0 ? '' : \substr($token['content'], $pos - 1, 1);
                $afterChar = \substr($token['content'], $pos + \strlen($import), 1);

                if (\in_array($beforeChar, self::CHARS_AROUND_USAGE, true) && \in_array($afterChar, self::CHARS_AROUND_USAGE, true)) {
                    return;
                }

                $pos++;
            }
        }

        $phpcsFile->addError(
            \sprintf('Unused import: %s.', $import),
            $stackPtr,
            ErrorCodes::UNUSED
        );
    }
}
