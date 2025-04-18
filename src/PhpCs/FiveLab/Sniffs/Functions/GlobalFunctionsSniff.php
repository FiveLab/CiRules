<?php

declare(strict_types = 1);

/**
 * This file is part of the FiveLab CiRules package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Functions;

use FiveLab\Component\CiRules\PhpCs\FiveLab\ErrorCodes;
use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\AbstractFunctionCallSniff;
use PHP_CodeSniffer\Files\File;

/**
 * Check global functions
 */
class GlobalFunctionsSniff extends AbstractFunctionCallSniff
{
    protected function processFunctionCall(File $phpcsFile, int $stackPtr, array $parenthesisPtrs): void
    {
        $tokens = $phpcsFile->getTokens();

        $prevTokenPtr = $phpcsFile->findPrevious([T_WHITESPACE], $stackPtr - 1, null, true);
        $prevToken = $tokens[$prevTokenPtr];

        $possiblePrevTokens = [T_OBJECT_OPERATOR, T_DOUBLE_COLON, T_NEW];

        if (\in_array($prevToken['code'], $possiblePrevTokens, true)) {
            // Call to object method or class method or create new instance. Ignore.
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
