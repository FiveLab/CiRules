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
 * Check the multi line arguments.
 */
class MultiLineArgumentsSniff implements Sniff
{
    public int $onlyInOneLine = 1;

    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_FUNCTION,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();

        $startPtr = (int) $phpcsFile->findNext([T_OPEN_PARENTHESIS], $stackPtr);
        $endPtr = (int) $phpcsFile->findNext([T_OPEN_CURLY_BRACKET, T_SEMICOLON], $stackPtr);
        $endPtr = (int) $phpcsFile->findPrevious([T_CLOSE_PARENTHESIS], $endPtr);

        $startToken = $tokens[$startPtr];
        $endToken = $tokens[$endPtr];
        $isMultiLine = $startToken['line'] !== $endToken['line'];

        if (!$isMultiLine) {
            return;
        }

        $contentsBetweenPtrs = PhpCsUtils::getContentsBetweenPtrs(
            $phpcsFile,
            $startPtr + 1,
            $endPtr
        );

        if ('' === \trim($contentsBetweenPtrs)) {
            $phpcsFile->addError(
                'Multi line empty constructor is not allowed.',
                $stackPtr,
                ErrorCodes::WRONG_FORMAT
            );

            return;
        }

        $totalArguments = 0;
        $currentPtr = $startPtr;

        while (true) {
            $currentPtr = (int) $phpcsFile->findNext([T_VARIABLE], $currentPtr + 1);

            if (!$currentPtr || $currentPtr > $endPtr) {
                break;
            }

            $totalArguments++;
        }

        if ($totalArguments <= $this->onlyInOneLine) {
            $phpcsFile->addError(
                \sprintf('Multi line for %d arguments is not allowed.', $totalArguments),
                $stackPtr,
                ErrorCodes::WRONG_FORMAT
            );
        }
    }
}
