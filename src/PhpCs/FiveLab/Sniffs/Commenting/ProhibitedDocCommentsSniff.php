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

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Commenting;

use FiveLab\Component\CiRules\PhpCs\FiveLab\ErrorCodes;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ProhibitedDocCommentsSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_DOC_COMMENT_OPEN_TAG,
        ];
    }

    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $commentToken = $tokens[$stackPtr];
        $closePtr = $phpcsFile->findNext(T_DOC_COMMENT_CLOSE_TAG, $stackPtr + 1);

        $possiblyDeclaration = $phpcsFile->findNext([
            T_CLASS, T_INTERFACE, T_TRAIT, T_FUNCTION,
            T_ABSTRACT, T_FINAL, T_ENUM,
        ], $commentToken['comment_closer'] + 1, local: true);

        if ($possiblyDeclaration) {
            return;
        }

        $hasMetaTag = false;

        for ($i = $stackPtr + 1; $i < $closePtr; $i++) {
            if ($tokens[$i]['code'] === T_DOC_COMMENT_TAG) {
                $hasMetaTag = true;

                break;
            }
        }

        if (!$hasMetaTag) {
            $phpcsFile->addError(
                'PHPDoc must contain at least one meta tag like @param, @return, etc.',
                $stackPtr,
                ErrorCodes::PHPDOC_NOT_ALLOWED
            );
        }
    }
}
