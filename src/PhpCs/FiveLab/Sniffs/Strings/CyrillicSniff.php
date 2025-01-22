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

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Strings;

use FiveLab\Component\CiRules\PhpCs\FiveLab\ErrorCodes;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class CyrillicSniff implements Sniff
{
    private static array $cyrillicMap = [];

    public function __construct()
    {

        if (!self::$cyrillicMap) {
            for ($i = 0x410; $i <= 0x44F; $i++) {
                self::$cyrillicMap[mb_chr($i, 'UTF-8')] = true;
            }

            $extraCyrillicChars = [
                0x401, // Ё
                0x451, // ё
                0x404, // Є
                0x454, // є
                0x407, // Ї
                0x457, // ї
                0x406, // І
                0x456, // і
                0x490, // Ґ
                0x491, // ґ
            ];

            foreach ($extraCyrillicChars as $charCode) {
                self::$cyrillicMap[mb_chr($charCode, 'UTF-8')] = true;
            }
        }
    }

    public function register(): array
    {
        return [
            T_VARIABLE,
            T_CLASS,
            T_INTERFACE,
            T_FUNCTION,
            T_STRING,
            T_CONSTANT_ENCAPSED_STRING,
            T_DOUBLE_QUOTED_STRING,
            T_COMMENT,
            T_DOC_COMMENT_STRING,
        ];
    }

    public function process(File $phpcsFile, $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $content = $tokens[$stackPtr]['content'];

        if ($this->containsCyrillic($content)) {
            $phpcsFile->addError(
                'Use cyrillic symbols is forbidden: "%s"',
                $stackPtr,
                ErrorCodes::CYRILLIC_FOUND,
                [\trim($content)]
            );
        }
    }

    private function containsCyrillic(string $content): bool
    {
        foreach (mb_str_split($content) as $char) {
            if (array_key_exists($char, self::$cyrillicMap)) {
                return true;
            }
        }

        return false;
    }
}
