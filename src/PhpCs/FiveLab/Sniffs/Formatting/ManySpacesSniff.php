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

class ManySpacesSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_WHITESPACE,
        ];
    }

    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
        $content = $tokens[$stackPtr]['content'];

        // only spaces
        if (!\preg_match('/^ +$/', $content)) {
            return;
        }

        $nextPtr = $phpcsFile->findNext(T_WHITESPACE, $stackPtr + 1, null, true);
        $prevPtr = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);

        if (false === $prevPtr || \str_contains($tokens[$stackPtr - 1]['content'], \chr(10))) {
            return;
        }

        if (T_SEMICOLON !== $tokens[$nextPtr]['code'] && 1 === \strlen($token['content'])) {
            return;
        }

        if (T_SEMICOLON === $tokens[$nextPtr]['code']) {
            $phpcsFile->addError(
                'Too many spaces. There must be no space before a semicolon.',
                $stackPtr,
                ErrorCodes::MANY_SPACES
            );

            return;
        }

        if (T_DOUBLE_ARROW === $tokens[$nextPtr]['code']) {
            return;
        }

        if (T_MATCH_ARROW === $tokens[$nextPtr]['code']) {
            return;
        }

        if (T_CONST === $tokens[$stackPtr - 3]['code'] || T_CONST === ($tokens[$stackPtr - 5]['code'] ?? null)) {
            return;
        }

        if (T_ENUM_CASE === $tokens[$stackPtr - 3]['code']) {
            return;
        }

        $functionPtr = $phpcsFile->findPrevious([T_FUNCTION, T_CLOSURE, T_FN], $stackPtr);

        if (\array_key_exists('parenthesis_opener', $tokens[$functionPtr]) && \array_key_exists('parenthesis_closer', $tokens[$functionPtr])) {
            $open = $tokens[$functionPtr]['parenthesis_opener'];
            $close = $tokens[$functionPtr]['parenthesis_closer'];

            if ($stackPtr > $open && $stackPtr < $close) {
                return;
            }
        }

        $phpcsFile->addError(
            'Too many spaces. Must be one space.',
            $stackPtr,
            ErrorCodes::MANY_SPACES
        );
    }
}
