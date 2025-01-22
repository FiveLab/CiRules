<?php

declare(strict_types = 1);

namespace FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\Strings;

use FiveLab\Component\CiRules\PhpCs\FiveLab\Sniffs\Strings\CyrillicSniff;
use FiveLab\Component\CiRules\Tests\PhpCs\FiveLab\Sniffs\SniffTestCase;

class CyrillicSniffTest extends SniffTestCase
{
    protected function getSniffClass(): string
    {
        return CyrillicSniff::class;
    }

    public function provideDataSet(): array
    {
        return [
            'wrong' => [
                __DIR__.'/Resources/cyrillic/wrong.php',
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "Пространство"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "\'Файл\'"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "класс2"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "КОНСТАНТА"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "\'Значение\'"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "$переменная"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "\'Привет\'"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "Строка документации"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "Класс"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "// комментарий"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "метод"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "\'Тест\'"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "Интерфейс"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "Трейт"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
                [
                    //phpcs:ignore
                    'message' => 'Use cyrillic symbols is forbidden: "метка"',
                    'source'  => 'FiveLab.Strings.Cyrillic.CyrillicFound',
                ],
            ],
        ];
    }
}
