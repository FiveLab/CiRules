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
 * Check the multi line.
 */
class MultiLineSniff implements Sniff
{
    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_ELSEIF,
            T_FOR,
            T_FOREACH,
            T_IF,
            T_WHILE,
            T_INLINE_THEN,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $stmt = $tokens[$stackPtr];

        if (T_INLINE_THEN === $stmt['code']) {
            $lineTokens = \array_map(static function (array $token): string {
                return (string) $token['code'];
            }, PhpCsUtils::getTokensOnLine($phpcsFile, $stmt['line']));

            $diff = \array_values(\array_diff($lineTokens, Tokens::$emptyTokens));

            $then = \array_search(T_INLINE_THEN, $diff);
            $else = \array_search(T_INLINE_ELSE, $diff);

            if (false !== $then || false !== $else) {
                $startLine = (int) \array_key_exists($then - 1, $diff);
                $endLine = (int) \array_key_exists($else + 1, $diff);
            } else {
                $startLine = 0;
                $endLine = 1;
            }
        } else {
            $startLine = $stmt['line'];
            $endLine = $tokens[$stmt['parenthesis_closer']]['line'];
        }

        if ($startLine !== $endLine) {
            $phpcsFile->addError(
                'Multi line is not allowed.',
                $stackPtr,
                ErrorCodes::WRONG_FORMAT
            );
        }
    }
}
