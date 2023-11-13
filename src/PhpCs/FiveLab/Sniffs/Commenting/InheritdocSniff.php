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
use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\AbstractFunctionDocCommentSniff;
use PHP_CodeSniffer\Files\File;

/**
 * Check inheritdoc annotation.
 */
class InheritdocSniff extends AbstractFunctionDocCommentSniff
{
    /**
     * {@inheritdoc}
     */
    protected function processLines(File $phpcsFile, int $startLineNumber, array $lines, string $functionName): void
    {
        $commentBeforeInheritdoc = null;
        $commentAfterInheritdoc = null;
        $inheritdocLineNumber = null;

        foreach ($lines as $index => $comment) {
            if (0 === \stripos($comment, '{@inheritdoc}')) {
                if ('{@inheritdoc}' !== $comment) {
                    $phpcsFile->addErrorOnLine(
                        'The notation {@inheritdoc} must be in lower case.',
                        $startLineNumber + $index,
                        ErrorCodes::WRONG_FORMAT
                    );
                }

                $inheritdocLineNumber = $startLineNumber + $index;
                $commentBeforeInheritdoc = $lines[$index - 1] ?? null;
                $commentAfterInheritdoc = $lines[$index + 1] ?? null;
            }
        }

        if ($commentBeforeInheritdoc) {
            $phpcsFile->addErrorOnLine(
                'Must be one blank line before {@inheritdoc} notation.',
                (int) $inheritdocLineNumber,
                ErrorCodes::MISSED_LINE_BEFORE
            );
        }

        if ($commentAfterInheritdoc) {
            $phpcsFile->addErrorOnLine(
                'Must be one blank line after {@inheritdoc} notation.',
                (int) $inheritdocLineNumber,
                ErrorCodes::MISSED_LINE_AFTER
            );
        }

        if ($inheritdocLineNumber) {
            $this->assertExistDocInParents($phpcsFile, $inheritdocLineNumber, $functionName);
        }
    }

    /**
     * Check what method exist parent declaration.
     *
     * @param File   $phpcsFile
     * @param int    $line
     * @param string $methodName
     */
    private function assertExistDocInParents(File $phpcsFile, int $line, string $methodName): void
    {
        $declaredName = PhpCsUtils::getDeclaredClassName($phpcsFile);

        if (!$declaredName) {
            $phpcsFile->addErrorOnLine(
                \sprintf('The notation {@inheritdoc} presented for function "%s", but it not a method in class/interface.', $methodName),
                $line,
                ErrorCodes::MISSED
            );

            return;
        }

        try {
            $ref = new \ReflectionClass($declaredName);
        } catch (\ReflectionException $error) { // @phpstan-ignore-line
            return;
        }

        $implements = [$ref->getInterfaceNames(), $ref->getTraitNames()];

        while ($ref = $ref->getParentClass()) {
            $implements[][] = $ref->getName();
            $implements[] = $ref->getInterfaceNames();
            $implements[] = $ref->getTraitNames();
        }

        $implements = \array_merge(...$implements);
        $exist = false;

        foreach ($implements as $implement) {
            try {
                // Check if method declared as code.
                $implementRef = new \ReflectionClass($implement);

                if ($implementRef->hasMethod($methodName)) {
                    $exist = true;
                    break;
                }

                // Check if method declared in notations.
                $docComment = (string) $implementRef->getDocComment();
                $docCommentLines = \explode(PHP_EOL, $docComment);

                foreach ($docCommentLines as $docCommentLine) {
                    // Check for pattern: @method returnType methodName(arg1, arg2)
                    if (\preg_match('/^\*\s*@method (\S+) ([^\\\(]+)\s*\(/', \trim($docCommentLine), $parts)) {
                        if ($methodName === $parts[2]) {
                            $exist = true;
                            break;
                        }
                    }

                    // Check for pattern: @method methodName(arg1, arg2)
                    if (\preg_match('/^\*\s*@method ([^\\\(]+)\s*\(/', \trim($docCommentLine), $parts)) {
                        if ($methodName === $parts[1]) {
                            $exist = true;
                            break;
                        }
                    }
                }
            } catch (\ReflectionException $error) {
            }
        }

        if (!$exist) {
            $phpcsFile->addErrorOnLine(
                \sprintf('The notation {@inheritdoc} presented, but method "%s" does not declared in extended classes/interfaces.', $methodName),
                $line,
                ErrorCodes::MISSED
            );
        }
    }
}
