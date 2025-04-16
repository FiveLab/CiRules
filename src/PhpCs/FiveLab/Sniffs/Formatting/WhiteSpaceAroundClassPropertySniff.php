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

/**
 * Sniff for check blank lines around class property.
 */
class WhiteSpaceAroundClassPropertySniff implements Sniff
{
    private const BEFORE_TOKENS = [
        T_ATTRIBUTE_END         => T_ATTRIBUTE,
        T_DOC_COMMENT_CLOSE_TAG => T_DOC_COMMENT_OPEN_TAG
    ];

    private bool $previousTokenWhiteSpaceNeeded = false;

    public function register(): array
    {
        return [
            T_VARIABLE,
            T_CLASS,
            T_CONST,
        ];
    }

    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        if ($this->shouldAbort($phpcsFile, $stackPtr)) {
            return;
        }

        [$currentTokenStackPtr, $currentToken] = $this->findToken($phpcsFile, $stackPtr);

        $tokensOnLine = $this->getTokensOnLineNoWhiteSpaces($phpcsFile, $currentToken['line'] - 1);

        if ($stackPtr === $currentTokenStackPtr && !\count($tokensOnLine)) {
            $tokensOnLine = $this->getTokensOnLineNoWhiteSpaces($phpcsFile, $currentToken['line'] - 2);

            $tokensOnLine = \array_filter($tokensOnLine, static function (array $token): bool {
                return \in_array($token['code'], [T_CONST, T_USE], true);
            });

            if ($this->previousIsMultiLineVariable($phpcsFile, $stackPtr)) {
                return;
            }

            if (!$this->previousTokenWhiteSpaceNeeded && !\count($tokensOnLine)) {
                $phpcsFile->addError(
                    'Line before class property is not allowed.',
                    $stackPtr,
                    ErrorCodes::LINE_BEFORE_NOT_ALLOWED
                );
            }

            return;
        }

        if (\array_key_exists($currentToken['code'], self::BEFORE_TOKENS)) {
            $this->previousTokenWhiteSpaceNeeded = true;

            $this->processToken((int) $currentTokenStackPtr, $phpcsFile, $stackPtr);
        } else {
            $this->previousTokenWhiteSpaceNeeded = false;

            $this->processFunction($phpcsFile, $stackPtr);
        }
    }

    /**
     * Is multi line variable
     *
     * @param File $phpcsFile
     * @param int  $stackPtr
     *
     * @return bool
     */
    private function previousIsMultiLineVariable(File $phpcsFile, int $stackPtr): bool
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        $tokensOnLine = $this->getTokensOnLineNoWhiteSpaces($phpcsFile, $token['line'] - 2);
        $semicolonToken = $tokensOnLine[\count($tokensOnLine) - 1];

        $previousTokenStackPtr = $phpcsFile->findPrevious([T_VARIABLE, T_CONST], $stackPtr - 1);
        $previousToken = $tokens[$previousTokenStackPtr];

        return T_SEMICOLON === $semicolonToken['code'] && $semicolonToken['line'] !== $previousToken['line'];
    }

    /**
     * Find token
     *
     * @param File $phpcsFile
     * @param int  $stackPtr
     *
     * @return array
     */
    private function findToken(File $phpcsFile, int $stackPtr): array // @phpstan-ignore-line
    {
        $tokens = $phpcsFile->getTokens();
        $currentTokenStackPtr = $stackPtr;

        while (true) {
            $previousTokenStackPtr = $phpcsFile->findPrevious(\array_keys(self::BEFORE_TOKENS), (int) $currentTokenStackPtr - 1);

            $currentToken = $tokens[$currentTokenStackPtr];
            $previousToken = $tokens[$previousTokenStackPtr];

            $startOfStatementStackPtr = $currentTokenStackPtr;

            if ($currentTokenStackPtr !== $stackPtr) {
                $startOfStatementStackPtr = $phpcsFile->findPrevious(
                    [self::BEFORE_TOKENS[$currentToken['code']]],
                    (int) $currentTokenStackPtr
                );
            }

            if ($tokens[$startOfStatementStackPtr]['line'] - 1 !== $previousToken['line']) {
                break;
            }

            $currentTokenStackPtr = $previousTokenStackPtr;
            $currentToken = $previousToken;
        }

        return [(int) $currentTokenStackPtr, $currentToken];
    }

    private function shouldAbort(File $phpcsFile, int $stackPtr): bool
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        if (T_CLASS === $token['code']) {
            $this->previousTokenWhiteSpaceNeeded = false;

            return true;
        }

        $modifierStackPtr = $phpcsFile->findPrevious([T_PUBLIC, T_PROTECTED, T_PRIVATE, T_CONST], $stackPtr);

        if ($token['line'] !== $tokens[$modifierStackPtr]['line']) {
            return true;
        }

        $functionStackPtr = $phpcsFile->findPrevious([T_FUNCTION], $stackPtr);

        if ($token['line'] === $tokens[$functionStackPtr]['line']) {
            return true;
        }

        $startOfStatement = $tokens[$phpcsFile->findStartOfStatement($stackPtr)];

        if (\array_key_exists('nested_parenthesis', $startOfStatement)) {
            return true;
        }

        return false;
    }

    /**
     * Get tokens on specific line, no white spaces
     *
     * @param File $file
     * @param int  $line
     *
     * @return array<mixed>
     */
    private function getTokensOnLineNoWhiteSpaces(File $file, int $line): array
    {
        $tokensOnLine = PhpCsUtils::getTokensOnLine($file, $line);

        $tokensOnLine = \array_filter($tokensOnLine, static function (array $token): bool {
            return T_WHITESPACE !== $token['code'];
        });

        return \array_values($tokensOnLine);
    }

    /**
     * Process after
     *
     * @param int  $beforeToken
     * @param File $phpcsFile
     * @param int  $stackPtr
     */
    private function processToken(int $beforeToken, File $phpcsFile, int $stackPtr): void
    {
        if (0 === $beforeToken) {
            return;
        }

        $tokens = $phpcsFile->getTokens();

        $startOfStatement = (int) $phpcsFile->findPrevious(self::BEFORE_TOKENS[$tokens[$beforeToken]['code']], $beforeToken);

        $this->processBefore($phpcsFile, $stackPtr, $startOfStatement);
        $this->processAfter($phpcsFile, $stackPtr);
    }

    /**
     * Process before
     *
     * @param File $phpcsFile
     * @param int  $stackPtr
     * @param int  $startOfStatement
     */
    private function processBefore(File $phpcsFile, int $stackPtr, int $startOfStatement): void
    {
        $tokens = $phpcsFile->getTokens();

        $tokensOnLine = $this->getTokensOnLineNoWhiteSpaces($phpcsFile, $tokens[$startOfStatement]['line'] - 1);

        if (\count($tokensOnLine) && T_OPEN_CURLY_BRACKET !== $tokensOnLine[\count($tokensOnLine) - 1]['code']) {
            $phpcsFile->addError(
                'Must be one blank line before class property.',
                $stackPtr,
                ErrorCodes::MISSED_LINE_BEFORE
            );
        }

        if (!\count($tokensOnLine)) {
            $contentsBetween = PhpCsUtils::getContentsBetweenPtrs(
                $phpcsFile,
                (int) $phpcsFile->findPrevious([T_OPEN_CURLY_BRACKET], $startOfStatement) + 1,
                $startOfStatement - 1
            );

            if ('' === \trim($contentsBetween)) {
                $phpcsFile->addError(
                    'Line before class property is not allowed.',
                    $stackPtr,
                    ErrorCodes::LINE_BEFORE_NOT_ALLOWED
                );
            }
        }
    }

    private function processFunction(File $phpcsFile, int $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        $startPtr = (int) $phpcsFile->findNext([T_SEMICOLON], $stackPtr) + 1;
        $endPtr = (int) $phpcsFile->findNext(T_FUNCTION, $stackPtr) - 2;

        if ($startPtr < $endPtr) {
            $contentsBetween = PhpCsUtils::getContentsBetweenPtrs(
                $phpcsFile,
                (int) $phpcsFile->findNext([T_SEMICOLON], $stackPtr) + 1,
                (int) $phpcsFile->findNext(T_FUNCTION, $stackPtr) - 2
            );

            $tokensOnLine = $this->getTokensOnLineNoWhiteSpaces($phpcsFile, $token['line'] + 1);

            if (\count($tokensOnLine)) {
                foreach ($tokensOnLine as $token) {
                    if ($token['code'] === T_FUNCTION && '' === \trim($contentsBetween)) {
                        $phpcsFile->addError(
                            'Must be one blank line after class property or const.',
                            $stackPtr,
                            ErrorCodes::MISSED_LINE_AFTER
                        );
                    }
                }
            }
        }
    }

    private function processAfter(File $phpcsFile, int $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();

        $semicolonStackPtr = $phpcsFile->findNext([T_SEMICOLON], $stackPtr);
        $semicolonToken = $tokens[$semicolonStackPtr];

        $tokensOnLine = $this->getTokensOnLineNoWhiteSpaces($phpcsFile, $semicolonToken['line'] + 1);

        if (!\count($tokensOnLine)) {
            $startPtr = (int) $phpcsFile->findNext([T_SEMICOLON], $stackPtr) + 1;
            $endPtr = (int) $phpcsFile->findNext([T_OPEN_CURLY_BRACKET], $stackPtr);

            if ($startPtr < $endPtr) {
                $contentsBetween = PhpCsUtils::getContentsBetweenPtrs(
                    $phpcsFile,
                    $startPtr,
                    $endPtr
                );

                if ('' === \trim($contentsBetween)) {
                    $phpcsFile->addError(
                        'Line after class property is not allowed.',
                        $stackPtr,
                        ErrorCodes::LINE_AFTER_NOT_ALLOWED
                    );
                }
            }

            return;
        }

        if (T_CLOSE_CURLY_BRACKET !== $tokensOnLine[\count($tokensOnLine) - 1]['code']) {
            $phpcsFile->addError(
                'Must be one blank line after class property or const.',
                $stackPtr,
                ErrorCodes::MISSED_LINE_AFTER
            );
        }
    }
}
