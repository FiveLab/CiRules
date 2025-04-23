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

        $possiblyDeclaration = $phpcsFile->findNext([
            T_CLASS, T_INTERFACE, T_TRAIT, T_FUNCTION,
            T_ABSTRACT, T_FINAL,
        ], $commentToken['comment_closer'] + 1, local: true);

        if ($possiblyDeclaration) {
            return;
        }

        $varPtr = $phpcsFile->findNext(T_VARIABLE, $commentToken['comment_closer'] + 1, local: true);

        if ($varPtr) {
            $commentTokenPtr = $phpcsFile->findNext(T_DOC_COMMENT_TAG, ($stackPtr + 1), $commentToken['comment_closer'], local: true);

            if (false === $commentTokenPtr) {
                $phpcsFile->addError(
                    'PHPDoc comment can contains only @var here.',
                    $stackPtr,
                    ErrorCodes::PHPDOC_NOT_ALLOWED
                );

                return;
            }
        }

        $isOnlyVarTag = $this->isHasOnlyVarTag($phpcsFile, $stackPtr, $commentToken['comment_closer'], $tokens);

        if (true === $isOnlyVarTag) {
            return;
        }

        $phpcsFile->addError(
            'PHPDoc comment is not allowed here.',
            $stackPtr,
            ErrorCodes::PHPDOC_NOT_ALLOWED
        );

        return;

    }

    /**
     * Check has T_DOC_COMMENT_TAG another tags
     *
     * @param File              $phpcsFile
     * @param int               $startPtr
     * @param int               $endPtr
     * @param array<int, mixed> $tokens
     *
     * @return bool|null
     */
    private function isHasOnlyVarTag(File $phpcsFile, int $startPtr, int $endPtr, array $tokens): ?bool
    {
        $commentTokenPtr = $phpcsFile->findNext(T_DOC_COMMENT_TAG, ($startPtr + 1), $endPtr);

        if (false === $commentTokenPtr) {
            return null;
        }

        if ($commentTokenPtr && $tokens[$commentTokenPtr]['content'] !== '@var') {
            $phpcsFile->addError(
                \sprintf('PHPDoc comment tag %s is not allowed here.', $tokens[$commentTokenPtr]['content']),
                $commentTokenPtr,
                ErrorCodes::PHPDOC_NOT_ALLOWED
            );

            return false;
        }

        $this->isHasOnlyVarTag($phpcsFile, $commentTokenPtr, $endPtr, $tokens);

        return true;
    }
}
