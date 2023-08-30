<?php

/*
 * This file is part of the FiveLab CiRules package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

declare(strict_types = 1);

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Commenting;

use FiveLab\Component\CiRules\PhpCs\FiveLab\ErrorCodes;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Check white space after start comment via "//"
 */
class WhiteSpaceAfterCommentStartSniff implements Sniff
{
    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_COMMENT,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $content = $phpcsFile->getTokens()[$stackPtr]['content'];
        $content = \rtrim($content);

        if ($content && 0 === \strpos($content, '//')) {
            $content = \substr($content, 2);

            if ($content && $content[0] !== ' ') {
                $phpcsFile->addError(
                    'Must be one space after open comment.',
                    $stackPtr,
                    ErrorCodes::WRONG_FORMAT
                );
            }
        }
    }
}
