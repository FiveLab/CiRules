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
use FiveLab\Component\CiRules\PhpCs\FiveLab\PhpCsUtils;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Prohibited {@inheritdoc} only comment.
 */
class ProhibitedInheritdocOnlySniff implements Sniff
{
    public function register(): array
    {
        return [
            T_DOC_COMMENT_OPEN_TAG,
        ];
    }

    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $closeTokenPtr = $phpcsFile->findNext([T_DOC_COMMENT_CLOSE_TAG], $stackPtr);

        $contentsBetweenPtrs = PhpCsUtils::getContentsBetweenPtrs($phpcsFile, $stackPtr, $closeTokenPtr + 1);
        $contentsBetweenPtrs = \str_replace([PHP_EOL, ' '], '', $contentsBetweenPtrs);

        if ('/***{@inheritdoc}*/' === $contentsBetweenPtrs) {
            $phpcsFile->addError(
                'Prohibited {@inheritdoc} only comment.',
                $stackPtr,
                ErrorCodes::PROHIBITED
            );
        }
    }
}
