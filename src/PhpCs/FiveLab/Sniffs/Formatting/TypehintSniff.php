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

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Formatting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Check function/method typehint.
 */
class TypehintSniff implements Sniff
{
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
    final public function process(File $phpcsFile, $stackPtr)
    {
        $methodParameters = $phpcsFile->getMethodParameters($stackPtr);
        $methodProperties = $phpcsFile->getMethodProperties($stackPtr);

        foreach ($methodParameters as $methodParameter) {
            if ('' === $methodParameter['type_hint']) {
                $phpcsFile->addError('Missing function parameter type.', $stackPtr, 'MissingFunctionParameterType');
            }
        }

        $fnPtr = $phpcsFile->findNext([T_STRING, T_OPEN_PARENTHESIS], $stackPtr);

        if (false !== $fnPtr) {
            $fnToken = $phpcsFile->getTokens()[$fnPtr];

            if (T_STRING === $fnToken['code'] && '__' !== \substr($fnToken['content'], 0, 2)) {
                if ('' === $methodProperties['return_type']) {
                    $phpcsFile->addError('Missing function return type.', $stackPtr, 'MissingFunctionReturnType');
                }
            }
        }
    }
}
