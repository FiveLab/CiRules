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
 * Sniff for check semicolon single char.
 */
class SemicolonSingleCharSniff implements Sniff
{
    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_SEMICOLON,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, $stackPtr): void
    {
        $tokens = \array_map(static function (array $token): string {
            return (string) $token['code'];
        }, PhpCsUtils::getTokensOnLine($phpcsFile, $phpcsFile->getTokens()[$stackPtr]['line']));

        $diff = \array_diff($tokens, Tokens::$emptyTokens);

        if (1 === \count($diff)) {
            $phpcsFile->addError(
                'Close semicolon must be on one line with method/function call.',
                $stackPtr,
                ErrorCodes::WRONG_FORMAT,
            );
        }
    }
}
