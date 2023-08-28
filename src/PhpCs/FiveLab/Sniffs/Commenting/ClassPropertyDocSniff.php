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
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Check class property doc comments.
 */
class ClassPropertyDocSniff implements Sniff
{
    /**
     * {@inheritdoc}
     */
    public function register(): array
    {
        return [
            T_DOC_COMMENT_OPEN_TAG,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        $functionPtr = $phpcsFile->findNext([T_FUNCTION], $token['comment_closer'] + 1, null, false, null, true);
        $openParenthesisPtr = $phpcsFile->findNext([T_OPEN_PARENTHESIS], $token['comment_closer'] + 1, null, false, null, true);

        if ($functionPtr || $openParenthesisPtr) {
            // This is a function.
            return;
        }

        $visibilityPtr = $phpcsFile->findNext([T_PRIVATE, T_PROTECTED, T_PUBLIC], $token['comment_closer'] + 1, null, false, null, true);
        $varPtr = $phpcsFile->findNext([T_VARIABLE], $token['comment_closer'] + 1, null, false, null, true);

        if (!$visibilityPtr || !$varPtr) {
            // After close comment we must have visibility scope and variable.
            return;
        }

        $docComment = $phpcsFile->getTokensAsString($stackPtr, ($token['comment_closer'] - $stackPtr) + 1);
        $commentLines = \explode($phpcsFile->eolChar, $docComment); // @phpstan-ignore-line

        foreach ($commentLines as $line) {
            if (\preg_match('/@var/', $line) && \count($commentLines) < 3) {
                $phpcsFile->addError(
                    'The annotation @var can\'t be on one line for class property. Please use multiline.',
                    $stackPtr,
                    ErrorCodes::WRONG_FORMAT
                );
            }
        }
    }
}
