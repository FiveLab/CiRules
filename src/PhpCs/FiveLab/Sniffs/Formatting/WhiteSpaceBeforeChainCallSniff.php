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
 * Sniff for check whitespaces count before chain call.
 */
class WhiteSpaceBeforeChainCallSniff implements Sniff
{
    const GAP = 4;

    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_OBJECT_OPERATOR,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, $stackPtr): void
    {
        $token = $phpcsFile->getTokens()[$stackPtr];

        $currentLine = $token['line'];
        $nonEmptyTokensOnCurrentLine = $this->getNonEmptyTokensOnLine($phpcsFile, $currentLine);
        $currentLineWhitespaces = $this->calculateWhitespacesBeforeFirstTokenOnLine($phpcsFile, $currentLine);

        if ($nonEmptyTokensOnCurrentLine[0]['column'] !== $token['column']) {
            return;
        }

        $prevLine = $token['line'] - 1;
        $nonEmptyTokensOnPrevLine = $this->getNonEmptyTokensOnLine($phpcsFile, $prevLine);

        while (!\count($nonEmptyTokensOnPrevLine)) {
            $prevLine--;

            $nonEmptyTokensOnPrevLine = $this->getNonEmptyTokensOnLine($phpcsFile, $prevLine);
        }

        $prevLineWhitespaces = $this->calculateWhitespacesBeforeFirstTokenOnLine($phpcsFile, $prevLine);

        $startPtr = $phpcsFile->findStartOfStatement($stackPtr);
        $endPtr = $phpcsFile->findEndOfStatement($stackPtr);

        $startToken = $phpcsFile->getTokens()[$startPtr];
        $endToken = $phpcsFile->getTokens()[$endPtr];

        $prevStarted = $prevLine === $startToken['line'];
        $currentEnds = $currentLine === $endToken['line'];

        $allowedWhitespaces = [];

        if ($prevStarted) {
            $allowedWhitespaces[] = $prevLineWhitespaces + self::GAP;
        } else {
            $allowedWhitespaces[] = $prevLineWhitespaces;

            if ($prevLineWhitespaces >= self::GAP) {
                $allowedWhitespaces[] = $prevLineWhitespaces - self::GAP;
            }

            if (!$currentEnds) {
                $allowedWhitespaces[] = $prevLineWhitespaces + self::GAP;
            }
        }

        if (\in_array($currentLineWhitespaces, $allowedWhitespaces, true)) {
            return;
        }

        \sort($allowedWhitespaces);

        $phpcsFile->addError(
            \sprintf(
                'Must be %s whitespaces before chain call.',
                \implode(' or ', $allowedWhitespaces)
            ),
            $stackPtr,
            ErrorCodes::WRONG_FORMAT
        );
    }

    /**
     * Calculate whitespaces before first token on line
     *
     * @param File $phpcsFile
     * @param int  $line
     *
     * @return int
     */
    private function calculateWhitespacesBeforeFirstTokenOnLine(File $phpcsFile, int $line): int
    {
        $whitespaces = 0;

        foreach (PhpCsUtils::getTokensOnLine($phpcsFile, $line) as $token) {
            if (T_WHITESPACE === $token['code']) {
                $whitespaces += $token['length'];
                continue;
            }

            break;
        }

        return $whitespaces;
    }

    /**
     * Get non empty tokens on line
     *
     * @param File $phpcsFile
     * @param int  $line
     *
     * @return array<mixed>
     */
    private function getNonEmptyTokensOnLine(File $phpcsFile, int $line): array
    {
        $tokens = PhpCsUtils::getTokensOnLine($phpcsFile, $line);

        $tokens = \array_filter($tokens, static function (array $token): bool {
            return !\in_array($token['code'], Tokens::$emptyTokens);
        });

        return \array_values($tokens);
    }
}
