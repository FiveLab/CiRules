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

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Functions;

use FiveLab\Component\CiRules\PhpCs\FiveLab\ErrorCodes;
use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;

/**
 * Check global functions
 */
class GlobalFunctionsSniff extends AbstractFunctionCallSniff
{
    /**
     * {@inheritdoc}
     */
    protected function processFunctionCall(File $phpcsFile, int $stackPtr, array $parenthesisPtrs): void
    {
        $tokens = $phpcsFile->getTokens();

        $prevTokenPtr = $phpcsFile->findPrevious([T_WHITESPACE], $stackPtr - 1, null, true);
        $prevToken = $tokens[$prevTokenPtr];

        $oopCalls = [T_OBJECT_OPERATOR, T_DOUBLE_COLON];

        if (\in_array($prevToken['code'], $oopCalls, true)) {
            // Call to object method or class method. Ignore.
            return;
        }

        $functionToken = $tokens[$stackPtr];

        if ($functionToken['code'] === T_STRING && \function_exists('\\'.$functionToken['content'])) {
            // Use global functions. Must use NS separator.
            if ($tokens[$stackPtr - 1]['code'] !== T_NS_SEPARATOR) {
                $phpcsFile->addError(
                    \sprintf('Must use NS separator (\) for global functions (%s).', $functionToken['content']),
                    $stackPtr,
                    ErrorCodes::WRONG_FORMAT
                );
            }
        }
    }
}
