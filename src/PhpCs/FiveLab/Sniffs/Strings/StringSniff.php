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

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Strings;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Check strings
 */
class StringSniff implements Sniff
{
    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_CONSTANT_ENCAPSED_STRING,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $token = $phpcsFile->getTokens()[$stackPtr];

        $content = $token['content'];
        $firstQuote = $content[0];

        if ('"' === $firstQuote) {
            $phpcsFile->addError('Use double quotes is forbidden.', $stackPtr, 'DoubleQuotes');
        }
    }
}
