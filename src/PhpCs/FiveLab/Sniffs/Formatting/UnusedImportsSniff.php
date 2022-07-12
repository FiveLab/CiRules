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
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Check the unused imports.
 */
class UnusedImportsSniff implements Sniff
{
    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_USE,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();

        if (1 !== $tokens[$stackPtr]['column'] || 0 !== $tokens[$stackPtr]['level']) {
            return;
        }

        $currentStackPtr = $phpcsFile->findNext(T_SEMICOLON, $stackPtr);
        $import = $tokens[$currentStackPtr - 1]['content'];

        while ($currentStackPtr = $phpcsFile->findNext([T_DOC_COMMENT_STRING, T_STRING], ++$currentStackPtr)) {
            $token = $tokens[$currentStackPtr];

            $search = T_DOC_COMMENT_STRING === $token['code'] ? \explode('|', $token['content']) : [$token['content']];

            foreach ($search as $value) {
                $pos = 0 === \strpos($value, $import);
                $char = \in_array(\substr($value, \strlen($import), 1), ['', '[', '<']);

                if ($pos && $char) {
                    return;
                }
            }
        }

        $phpcsFile->addError(
            \sprintf('Unused import: %s.', $import),
            $stackPtr,
            ErrorCodes::UNUSED
        );
    }
}
