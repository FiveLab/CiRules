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

namespace FiveLab\Component\CiRules\PhpStan;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

class NamespaceConsistencyRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Stmt\Namespace_::class;
    }

    /**
     * @param Node\Stmt\Namespace_ $node
     * @param Scope                $scope
     *
     * @return array
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $filePath = $scope->getFile();
        $declaredNamespace = $node->name?->toString();
        $expectedNamespace = $this->getExpectedNamespace($filePath, $scope);
        if ($declaredNamespace !== $expectedNamespace) {
            return [
                \sprintf(
                    'Namespace mismatch in file "%s". Expected namespace "%s", found "%s".',
                    $filePath,
                    $expectedNamespace,
                    $declaredNamespace
                ),
            ];
        }

        return [];
    }

    private function getExpectedNamespace(string $filePath, Scope $scope): ?string
    {
        $composerJsonPath = $this->findProjectComposerJson($scope);
        $composerJson = $this->loadComposerJson($composerJsonPath);

        $psr4 = \array_merge(
            $composerJson['autoload']['psr-4'] ?? [],
            $composerJson['autoload-dev']['psr-4'] ?? []
        );

        foreach ($psr4 as $namespace => $directory) {
            $normalizedDirectory = \realpath(\dirname($composerJsonPath).'/'.$directory);
            $normalizedFilePath = \realpath($filePath);

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

    private function findProjectComposerJson(Scope $scope): string
    {
        $projectDir = $scope->getFile();
        $currentDir = \dirname($projectDir);

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
