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
        $endPtr = (int) $phpcsFile->findNext([T_CLOSE_PARENTHESIS], $stackPtr);

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

        $argumentLines = \array_filter(\explode(PHP_EOL, $contentsBetweenPtrs), static function (string $argumentLine): bool {
            return '' !== \trim($argumentLine);
        });

        $totalArguments = \array_reduce($argumentLines, static function (int $carry, string $argumentLine): int {
            $arguments = \array_filter(\explode(',', $argumentLine), static function (string $argument): bool {
                return '' !== \trim($argument);
            });

            $carry += \count($arguments);

            return $carry;
        }, 0);

        if ($totalArguments <= $this->onlyInOneLine) {
            $phpcsFile->addError(
                \sprintf('Multi line for %d arguments is not allowed.', $totalArguments),
                $stackPtr,
                ErrorCodes::WRONG_FORMAT
            );
        }
    }
}
