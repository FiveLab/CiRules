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

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Attributes;

use FiveLab\Component\CiRules\PhpCs\FiveLab\ErrorCodes;
use FiveLab\Component\CiRules\PhpCs\FiveLab\PhpCsUtils;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Prohibited attribute.
 */
class ProhibitedAttributeSniff implements Sniff
{
    public string $attributes = '';

    public function register(): array
    {
        return [
            T_ATTRIBUTE,
        ];
    }

    public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $endAttributeName = (int) $phpcsFile->findNext([T_ATTRIBUTE_END, T_OPEN_PARENTHESIS], $stackPtr);
        $contentsBetweenPtrs = \explode('\\', PhpCsUtils::getContentsBetweenPtrs($phpcsFile, $stackPtr + 1, $endAttributeName));

        $prohibitedAttributes = \array_map('\trim', \explode(',', $this->attributes));

        if (\in_array($contentsBetweenPtrs[\count($contentsBetweenPtrs) - 1], $prohibitedAttributes, true)) {
            $phpcsFile->addError(
                'Prohibited attribute.',
                $stackPtr,
                ErrorCodes::PROHIBITED
            );
        }
    }
}
