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

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Commenting;

use FiveLab\Component\CiRules\PhpCs\FiveLab\ErrorCodes;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ProhibitedCommentsSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_COMMENT,
        ];
    }

    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $commentToken = $tokens[$stackPtr];
        $isInsideFunction = false;

        if (\str_contains($commentToken['content'], '@phpstan')) {
            return;
        }

        if (\str_starts_with($commentToken['content'], '\*') || \str_starts_with($commentToken['content'], ' *') || \str_starts_with($commentToken['content'], '/*')) {
            $beginPtr = $stackPtr;

            foreach ($tokens as $ptr => $token) {
                if (T_NAMESPACE === $token['code']) {
                    if ($beginPtr < $ptr) {
                        return;
                    }
                }
            }
        }

        foreach ($tokens as $token) {
            if ($token['code'] === T_OPEN_CURLY_BRACKET) {
                $conditionToken = $tokens[$token['scope_condition']];

                if (\in_array($conditionToken['code'], [T_FUNCTION, T_CLOSURE], true)) {
                    if ($stackPtr > $token['scope_opener'] && $stackPtr < $token['scope_closer']) {
                        $isInsideFunction = true;
                        break;
                    }
                }
            }
        }

        if (!$isInsideFunction) {
            $phpcsFile->addError(
                'Simple comments who start with "//, #, /* " prohibited inside function bodies.',
                $stackPtr,
                ErrorCodes::COMMENT_OUTSIDE_FUNCTION_BODY
            );
        }
    }
}
