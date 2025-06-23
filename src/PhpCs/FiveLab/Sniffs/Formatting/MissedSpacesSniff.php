<?php

declare(strict_types = 1);

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting;

use FiveLab\Component\CiRules\PhpCs\FiveLab\ErrorCodes;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class MissedSpacesSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_BOOLEAN_AND,
            T_BOOLEAN_OR,
            T_INLINE_THEN,
            T_INLINE_ELSE,
        ];
    }

    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        if ($tokens[$stackPtr - 1]['code'] !== T_WHITESPACE) {
            if ($token['code'] === T_INLINE_ELSE || $token['code'] === T_INLINE_THEN) {
                $this->analiseThenElse($phpcsFile, $stackPtr, true);

                return;
            }

            $phpcsFile->addError(
                'Missed one space before logical operand.',
                $stackPtr,
                ErrorCodes::MISSED_SPACE
            );
        }

        if ($tokens[$stackPtr + 1]['code'] !== T_WHITESPACE) {
            if ($token['code'] === T_INLINE_THEN || $token['code'] === T_INLINE_ELSE) {
                $this->analiseThenElse($phpcsFile, $stackPtr, false);

                return;
            }

            $phpcsFile->addError(
                'Missed one space after logical operand.',
                $stackPtr,
                ErrorCodes::MISSED_SPACE
            );
        }
    }

    private function analiseThenElse(File $phpcsFile, mixed $stackPtr, bool $before): void
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        if ($token['code'] === T_INLINE_THEN) {
            if ($before) {
                $phpcsFile->addError(
                    'Missed one space before logical operand.',
                    $stackPtr,
                    ErrorCodes::MISSED_SPACE
                );

                return;
            }

            if ($tokens[$stackPtr + 1]['code'] === T_INLINE_ELSE) {
                return;
            }

            $phpcsFile->addError(
                'Missed one space after logical operand.',
                $stackPtr,
                ErrorCodes::MISSED_SPACE
            );
        }

        if ($token['code'] === T_INLINE_ELSE) {
            if ($before) {
                if ($tokens[$stackPtr - 1]['code'] === T_INLINE_THEN) {
                    if ($tokens[$stackPtr + 1]['code'] !== T_WHITESPACE) {
                        $phpcsFile->addError(
                            'Missed one space after logical operand.',
                            $stackPtr,
                            ErrorCodes::MISSED_SPACE
                        );
                    }

                    return;
                }

                $phpcsFile->addError(
                    'Missed one space before logical operand.',
                    $stackPtr,
                    ErrorCodes::MISSED_SPACE
                );

                return;
            }

            $phpcsFile->addError(
                'Missed one space after logical operand.',
                $stackPtr,
                ErrorCodes::MISSED_SPACE
            );
        }
    }
}
