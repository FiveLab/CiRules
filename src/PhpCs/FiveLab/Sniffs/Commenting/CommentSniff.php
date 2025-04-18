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

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Commenting;

use FiveLab\Component\CiRules\PhpCs\FiveLab\ErrorCodes;
use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\AbstractFunctionDocCommentSniff;
use PHP_CodeSniffer\Files\File;

/**
 * Check function/method doc comments.
 */
class CommentSniff extends AbstractFunctionDocCommentSniff
{
    protected function processLines(File $phpcsFile, int $startLineNumber, array $lines, string $functionName, int $countCommentLines): void
    {
        if (1 === $countCommentLines) {
            $phpcsFile->addErrorOnLine(
                'A method or function cannot have a single line comment.',
                $startLineNumber,
                ErrorCodes::WRONG_FORMAT
            );
        }

        $startCommentLine = null;
        $startAnnotationLine = null;

        $endCommentLine = null;
        $existInheritdoc = false;

        foreach ($lines as $lineIndex => $line) {
            if (\preg_match('#\{@inheritdoc}#i', $line)) {
                $existInheritdoc = true;
            }

            if ($line && !\str_starts_with($line, '@')) {
                $endCommentLine = (int) $lineIndex;
                $startCommentLine = (int) ($startCommentLine ?? $lineIndex);
            }

            if (\str_starts_with($line, '@')) {
                $startAnnotationLine = (int) ($startAnnotationLine ?? $lineIndex);
            }
        }

        if (!$existInheritdoc && null === $endCommentLine) {
            // Not inheritdoc and any comment.
            $phpcsFile->addErrorOnLine(
                'The method or function must contain comment. Please add short description.',
                $startLineNumber,
                'MissingFunctionComment'
            );
        }

        if (null !== $endCommentLine && \array_key_exists($endCommentLine + 1, $lines) && $lines[$endCommentLine + 1]) {
            $phpcsFile->addErrorOnLine(
                'Must be one blank line between comment and annotations.',
                $startLineNumber + $endCommentLine,
                ErrorCodes::MISSED_LINE_AFTER
            );
        }

        if (null !== $startCommentLine && null !== $startAnnotationLine && $startCommentLine > $startAnnotationLine) {
            $phpcsFile->addErrorOnLine(
                'Previously must be a comment and after annotations.',
                $startLineNumber,
                ErrorCodes::WRONG_FORMAT
            );
        }

        if (\count($lines) && !$lines[\count($lines) - 1]) {
            $phpcsFile->addErrorOnLine(
                'Between end comment/notations and close comment tag can\'t be blank lines.',
                $startLineNumber + \count($lines),
                ErrorCodes::WRONG_FORMAT
            );
        }
    }
}
