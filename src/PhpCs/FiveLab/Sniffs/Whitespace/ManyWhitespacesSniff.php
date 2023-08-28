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

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Whitespace;

use FiveLab\Component\CiRules\PhpCs\FiveLab\ErrorCodes;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Check many whitespaces.
 */
class ManyWhitespacesSniff implements Sniff
{
    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_OPEN_TAG,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();

        $whitespaceLines = 0;
        $addedError = false;

        for ($i = ($stackPtr + 1); $i < $phpcsFile->numTokens; $i++) {
            $token = $tokens[$i];

            if ($token['code'] !== T_WHITESPACE) {
                $whitespaceLines = 0;
                $addedError = false;

                continue;
            }

            if ($token['content'] !== PHP_EOL) {
                continue;
            }

            $whitespaceLines++;

            if ($whitespaceLines > 2 && !$addedError) {
                $addedError = true;

                $phpcsFile->addError(
                    'More blank lines. Can\'t be more then one blank line between code/comment blocks.',
                    $i,
                    ErrorCodes::MULTIPLE
                );
            }
        }
    }
}
