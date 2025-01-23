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

namespace FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Namespace;

use FiveLab\Component\CiRules\PhpCs\FiveLab\ErrorCodes;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class NamespaceSniff implements Sniff
{
    public function register(): array
    {
        return [T_NAMESPACE];
    }

    public function process(File $phpcsFile, $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();
        $endToken = $phpcsFile->findNext(T_SEMICOLON, $stackPtr);

        if (false === $endToken) {
            return;
        }

        $declaredNamespace = '';
        for ($i = $stackPtr + 1; $i < $endToken; $i++) {
            $declaredNamespace .= $tokens[$i]['content'];
        }

        $expectedNamespace = $this->getExpectedNamespace($phpcsFile);
        if (\trim($declaredNamespace) !== $expectedNamespace) {
            $phpcsFile->addError(
                'Namespace mismatch in file "%s". Expected namespace "%s", found "%s".',
                $stackPtr,
                ErrorCodes::NAMESPACE_WRONG,
                [$phpcsFile->path, $expectedNamespace, $declaredNamespace]
            );
        }
    }

    private function getExpectedNamespace(File $phpcsFile): ?string
    {
        $composerJsonPath = $this->findProjectComposerJson($phpcsFile);
        $composerJson = $this->loadComposerJson($composerJsonPath);

        $psr4 = \array_merge(
            $composerJson['autoload']['psr-4'] ?? [],
            $composerJson['autoload-dev']['psr-4'] ?? []
        );

        foreach ($psr4 as $namespace => $directory) {
            $normalizedDirectory = \realpath(\dirname($composerJsonPath).'/'.$directory);
            $normalizedFilePath = \realpath($phpcsFile->path);

            if ($normalizedDirectory && $normalizedFilePath && \str_starts_with($normalizedFilePath, $normalizedDirectory)) {
                $relativePath = \substr($normalizedFilePath, \strlen($normalizedDirectory) + 1);
                $expectedNamespace = \rtrim($namespace, '\\').'\\'.\str_replace('/', '\\', \dirname($relativePath));

                return \trim($expectedNamespace, '\\, .');
            }
        }

        return null;
    }

    private function loadComposerJson(string $composerJsonPath): array
    {
        if (!\file_exists($composerJsonPath)) {
            throw new \RuntimeException(\sprintf('composer.json not found at "%s".', $composerJsonPath));
        }

        $content = \file_get_contents($composerJsonPath);

        $decoded = $content ? \json_decode($content, true, flags: JSON_THROW_ON_ERROR) : null;

        if (!\is_array($decoded)) {
            throw new \RuntimeException(\sprintf('Invalid composer.json format at "%s".', $composerJsonPath));
        }

        return $decoded;
    }

    private function findProjectComposerJson(File $phpcsFile): string
    {
        $currentDir = \dirname($phpcsFile->getFilename());

        while ($currentDir !== \dirname($currentDir)) {
            $composerJsonPath = $currentDir.'/composer.json';
            if (\file_exists($composerJsonPath)) {
                return $composerJsonPath;
            }

            $currentDir = \dirname($currentDir);
        }

        throw new \RuntimeException('composer.json not found in the project root.');
    }
}
