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

class AnnotationsSniff extends AbstractFunctionDocCommentSniff
{
    protected function processLines(File $phpcsFile, int $startLineNumber, array $lines, string $functionName, int $countCommentLines): void
    {
        foreach ($lines as $lineNumber => $line) {
            if ($line && '@' === $line[0]) {
                @[$annotation, $value] = \explode(' ', $line);

                $annotation = \trim($annotation);
                $annotation = \substr($annotation, 1);
                $value = \trim((string) $value);

                $this->processAnnotation($phpcsFile, $startLineNumber + $lineNumber, $annotation, $value);
            }
        }
    }

    private function processAnnotation(File $phpcsFile, int $lineNumber, string $annotation, string $value): void
    {
        if ('return' === $annotation && 'void' === $value) {
            $phpcsFile->addErrorOnLine(
                '`@return void` doc block comments are prohibited. Please add void to return type hint.',
                $lineNumber,
                ErrorCodes::PROHIBITED
            );
        }

        if ('throws' === $annotation) {
            $nsParts = \explode('\\', $value);
            $nsParts = \array_map('\trim', $nsParts);
            $nsParts = \array_filter($nsParts);

            if (\count($nsParts) > 1) {
                $phpcsFile->addErrorOnLine(
                    'Please import error class in "use" block and use short class name in @throws annotation.',
                    $lineNumber,
                    ErrorCodes::PROHIBITED
                );
            }
        }

        if (\str_contains($value, '[]')) {
            $phpcsFile->addErrorOnLine(
                'Please use vector type annotation for arrays.',
                $lineNumber,
                ErrorCodes::ARRAYS_DOC_VECTOR
            );
        }
    }
}
