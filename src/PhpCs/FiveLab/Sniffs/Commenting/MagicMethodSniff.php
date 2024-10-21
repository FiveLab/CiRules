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
use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\AbstractFunctionDocCommentSniff;
use PHP_CodeSniffer\Files\File;

/**
 * Check comments about magic methods.
 */
class MagicMethodSniff extends AbstractFunctionDocCommentSniff
{
    protected function processLines(File $phpcsFile, int $startLineNumber, array $lines, string $functionName): void
    {
        if (0 !== \strpos($functionName, '__')) {
            // Not a magic method.
            return;
        }

        if ('__construct' === $functionName) {
            $firstLine = $lines[0] ?? '';

            if ('Constructor.' !== $firstLine) {
                $phpcsFile->addErrorOnLine(
                    'The method __construct must contain only "Constructor." comment on first line.',
                    $startLineNumber,
                    ErrorCodes::WRONG_FORMAT
                );
            }
        }
    }
}
