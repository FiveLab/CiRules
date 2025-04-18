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

namespace FiveLab\Component\CiRules\PhpCs\FiveLab;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

/**
 * The utilities for phpcs file object.
 */
final class PhpCsUtils
{
    /**
     * Get contents between two token positions.
     *
     * @param File $file
     * @param int  $startPtr
     * @param int  $endPtr
     *
     * @return string
     */
    public static function getContentsBetweenPtrs(File $file, int $startPtr, int $endPtr): string
    {
        $content = '';
        $tokens = $file->getTokens();

        for ($i = $startPtr; $i < $endPtr; $i++) {
            $content .= $tokens[$i]['content'];
        }

        return $content;
    }

    /**
     * Get diff lines with ignored comments.
     *
     * @param File $file
     * @param int  $fromPtr
     * @param int  $toPtr
     *
     * @return int
     */
    public static function getDiffLines(File $file, int $fromPtr, int $toPtr): int
    {
        $tokens = $file->getTokens();
        $diffLines = 0;

        for ($i = $fromPtr; $i <= $toPtr; $i++) {
            $token = $tokens[$i];

            if ($token['code'] === T_WHITESPACE && $token['content'] === $file->eolChar) {
                $diffLines++;
            } elseif (\in_array($token['code'], Tokens::$commentTokens, true)) {
                if ($token['code'] === T_DOC_COMMENT_OPEN_TAG) {
                    $i = $file->findNext([T_DOC_COMMENT_CLOSE_TAG], $i + 1);
                } elseif ($token['code'] === T_COMMENT) {
                    $tokensOnLine = self::getTokensOnLine($file, $token['line']);
                    $existCodeOnLine = false;

                    foreach ($tokensOnLine as $tokenOnLine) {
                        if (!\in_array($tokenOnLine['code'], Tokens::$emptyTokens, true)) {
                            $existCodeOnLine = true;
                        }
                    }

                    if ($existCodeOnLine && \substr($token['content'], -1) === $file->eolChar) {
                        // Line contain code and exist comment on end of line.
                        $diffLines++;
                    } else {
                        $i++;
                    }
                } else {
                    // Comment ignored
                    $i++;
                }
            } elseif (\substr($token['content'], -1) === $file->eolChar) {
                $diffLines++;
            }
        }

        return $diffLines;
    }

    /**
     * Get tokens on specific line
     *
     * @param File $file
     * @param int  $line
     *
     * @return array<mixed>
     */
    public static function getTokensOnLine(File $file, int $line): array
    {
        return \array_filter($file->getTokens(), static function (array $token) use ($line) {
            return $token['line'] === $line;
        });
    }

    /**
     * Find first token ptr on the line
     *
     * @param File $file
     * @param int  $line
     *
     * @return int|null
     */
    public static function findFirstTokenOnLine(File $file, int $line): ?int
    {
        $tokens = $file->getTokens();
        $countTokens = \count($tokens);

        for ($i = 0; $i < $countTokens - 1; $i++) {
            if ($tokens[$i]['line'] === $line) {
                return $i;
            }
        }

        return null;
    }

    /**
     * Get declared class name
     *
     * @param File $file
     *
     * @return class-string
     */
    public static function getDeclaredClassName(File $file): ?string
    {
        $tokens = $file->getTokens();
        $namespace = '';

        $nsStart = $file->findNext([T_NAMESPACE], 0);

        if ($nsStart) {
            $nsEnd = $file->findNext([T_NS_SEPARATOR, T_STRING, T_WHITESPACE], $nsStart + 1, null, true);

            $namespace = \trim(self::getContentsBetweenPtrs($file, $nsStart + 1, (int) $nsEnd));
        }

        $declaredPtr = $file->findNext([T_CLASS, T_INTERFACE, T_TRAIT], 0);

        if (!$declaredPtr) {
            return null;
        }

        $nextTokenPtr = $file->findNext([T_WHITESPACE], $declaredPtr + 1, null, true);
        $nameToken = $tokens[$nextTokenPtr];

        if ($nameToken['code'] === T_STRING) {
            return $namespace ? $namespace.'\\'.$nameToken['content'] : $nameToken['content'];
        }

        return null;
    }
}
