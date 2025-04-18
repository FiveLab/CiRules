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

namespace FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Util\Common;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

abstract class SniffTestCase extends TestCase
{
    protected Config $config;
    protected Ruleset $ruleset;

    protected function setUp(): void
    {
        $this->config = new Config();
        $this->config->cache = false;

        $this->config->standards = [__DIR__.'/../../../../src/PhpCs/FiveLab'];
        $this->config->sniffs = [];
        $this->config->ignored = [];

        $this->ruleset = new Ruleset($this->config);

        $sniffClassRef = new \ReflectionClass($this->getSniffClass());

        $sniffClassName = $sniffClassRef->getName();
        $sniffClassName = Common::cleanSniffClass($sniffClassName);

        $this->ruleset->registerSniffs([$sniffClassRef->getFileName()], [\strtolower($sniffClassName) => true], []);
        $this->ruleset->populateTokenListeners();
    }

    #[Test]
    #[DataProvider('provideDataSet')]
    public function shouldSuccessProcessFile(string $file, array ...$expectedErrors): void
    {
        if ($this->isShouldIncludeFile()) {
            require_once $file;
        }

        $errors = $this->processFile($file);

        $this->assertErrors($expectedErrors, $errors);
    }

    /**
     * Run file
     *
     * @param string $file
     *
     * @return array{"line": int, "ptr": int, "message": string, "source": string}
     */
    private function processFile(string $file): array
    {
        $file = new LocalFile($file, $this->ruleset, $this->config);

        $file->process();

        $errors = $file->getErrors();
        $normalizedErrors = [];

        foreach ($errors as $lineNumber => $lineErrors) {
            foreach ($lineErrors as $ptr => $errorsInfo) {
                foreach ($errorsInfo as $errorInfo) {
                    $normalizedErrors[] = [
                        'line'    => $lineNumber,
                        'ptr'     => $ptr,
                        'message' => $errorInfo['message'],
                        'source'  => $errorInfo['source'],
                    ];
                }
            }
        }

        return $normalizedErrors;
    }

    private function assertErrors(array $expectedErrors, array $actualErrors): void
    {
        self::assertCount(\count($expectedErrors), $actualErrors, 'Count errors are not equals.');

        foreach ($actualErrors as $index => $actualError) {
            if (!\array_key_exists($index, $expectedErrors)) {
                self::fail(\sprintf(
                    'Can\'t pre-setup expected errors. The expected error with index "%d" was not foun.',
                    $index
                ));
            }

            if (!\array_key_exists('line', $expectedErrors[$index])) {
                $expectedErrors[$index]['line'] = $actualError['line'];
            }

            if (!\array_key_exists('ptr', $expectedErrors[$index])) {
                $expectedErrors[$index]['ptr'] = $actualError['ptr'];
            }
        }

        self::assertEquals($expectedErrors, $actualErrors);
    }

    protected function isShouldIncludeFile(): bool
    {
        return false;
    }

    /**
     * Get sniff file
     *
     * @return class-string
     */
    abstract protected function getSniffClass(): string;

    abstract public static function provideDataSet(): array;
}
