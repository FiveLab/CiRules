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
 * Check white spaced after opener.
 */
class WhiteSpaceAfterOpenerSniff implements Sniff
{
    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_OPEN_CURLY_BRACKET,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        $tokensOnLine = \array_filter(PhpCsUtils::getTokensOnLine($phpcsFile, $token['line'] + 1), static function (array $token): bool {
            return T_WHITESPACE !== $token['code'];
        });

        $tokensOnLine = \array_values($tokensOnLine);

        if (!\count($tokensOnLine)) {
            $phpcsFile->addError(
                'Line after opener is not allowed.',
                $stackPtr,
                ErrorCodes::LINE_AFTER_NOT_ALLOWED
            );
        }
    }
}
