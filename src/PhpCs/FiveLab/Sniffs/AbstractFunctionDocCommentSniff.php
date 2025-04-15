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

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

abstract class AbstractFunctionDocCommentSniff implements Sniff
{
    public function register(): array
    {
        return [
            T_DOC_COMMENT_OPEN_TAG,
        ];
    }

    final public function process(File $phpcsFile, mixed $stackPtr): void
    {
        $closeTokenPtr = $phpcsFile->findNext([T_DOC_COMMENT_CLOSE_TAG], $stackPtr);

        if (!$closeTokenPtr) {
            // Wrong comment in file.
            return;
        }

        $functionTokenPtr = $phpcsFile->findNext([T_FUNCTION], $closeTokenPtr + 1, null, false, null, true);

        if (!$functionTokenPtr) {
            // Not the function. On this position we must found "function" word.
            return;
        }

        $openCurlyBracketPtr = $phpcsFile->findNext([T_OPEN_CURLY_BRACKET], $closeTokenPtr + 1);

        if ($openCurlyBracketPtr && $openCurlyBracketPtr < $functionTokenPtr) {
            // Found open curly bracket previously then "function" keyword. Name of class/interface/trait.
            return;
        }

        $functionNameTokenPtr = $phpcsFile->findNext([T_WHITESPACE], $functionTokenPtr + 1, null, true);
        $functionNameToken = $phpcsFile->getTokens()[$functionNameTokenPtr];

        if ($functionNameToken['code'] !== T_STRING) {
            // Not the function. On this position we must found the function name.
            return;
        }

        $openParenthesisTokenPtr = $phpcsFile->findNext([T_WHITESPACE], $functionNameTokenPtr + 1, null, true);
        $openParenthesisToken = $phpcsFile->getTokens()[$openParenthesisTokenPtr];

        if ($openParenthesisToken['code'] !== T_OPEN_PARENTHESIS) {
            // Not the function. On this position we must found the open parenthesis for function arguments.
            return;
        }

        $commentContent = $phpcsFile->getTokensAsString($stackPtr, ($closeTokenPtr + 1) - $stackPtr);

        $startCommentLine = $phpcsFile->getTokens()[$stackPtr]['line'];

        $commentLines = \explode($phpcsFile->eolChar, $commentContent); // @phpstan-ignore-line
        $commentLines = \array_map('\trim', $commentLines);

        if ($commentLines[0] === '/**') {
            $startCommentLine++;
            \array_shift($commentLines);
        }

        if (\count($commentLines) && $commentLines[\count($commentLines) - 1] === '*/') {
            \array_pop($commentLines);
        }

        $commentLines = \array_map(static function ($line) {
            if ($line[0] === '*') {
                $line = \substr($line, 1);
                $line = \trim($line);
            }

            return $line;
        }, $commentLines);

        $this->processLines($phpcsFile, $startCommentLine, $commentLines, $functionNameToken['content']);
    }

    /**
     * Process lines
     *
     * @param File          $phpcsFile
     * @param int           $startLineNumber
     * @param array<string> $lines
     * @param string        $functionName
     */
    abstract protected function processLines(File $phpcsFile, int $startLineNumber, array $lines, string $functionName): void;
}
