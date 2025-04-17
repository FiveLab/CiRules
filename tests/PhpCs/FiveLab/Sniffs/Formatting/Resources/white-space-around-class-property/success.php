<?php

class Some
{
    private Some $bar; // @phpstan-ignore-line
    private Some $foo;
}

class Some
{
    private Some $bar;

    #[Attribute()]
    private Some $foo;
}

class Some
{
    /**
     * @var string|int
     */
    private Some $foo;

    /**
     * @var string|int
     */
    private mixed $bar;

    public function __construct(
        private string $baz
    ) {
    }
}

class Some
{
    private Some $foo;

    public function __construct()
    {
    }
}

class Some
{
    #[Attribute()]
    #[Attribute()]
    private Some $bar;

    #[Attribute()]
    #[Attribute()]
    private Some $foo;
}

class Some
{
    /**
     * @var string
     */
    #[Attribute(
        Some()
    )]
    private Some $foo;
}

class Some
{
    use SomeTrait;

    private string $foo;
}

class Some
{
    public const string A = 'A';
    public const string B = 'B';

    private const array C = [
        self::A,
        self::B,
    ];

    private const array D = [
        'a' => self::A,
        'b' => self::B,
    ];

    private const array E = [
        self::A => self::B,
        self::B => self::C,
    ];

    private string $foo;
}

class Some
{
    private array $foo = [
        'some' => 'value',
    ];

    private string $bar;
}

class Some
{
    /**
     * @var array<array<string|int>>
     */
    private static array $foo = [
        'some' => 'value',
    ];

    /**
     * @var array<array<string|int>>
     */
    private static array $bar = [
        'some' => 'value',
    ];
}

class Some
{
    /**
     * @var array<array<string|int>>
     */
    private static array $foo = [
        'some' => 'value',
    ];

    /**
     * @var array<array<string|int>>
     */
    private static array $bar = [
        'some' => 'value',
    ];

    public function __construct()
    {
    }
}

class Some
{
    private const array C = [
        self::A,
        self::B,
    ];

    public function foo(): void
    {
    }
}

class Some
{
    private array $foo = [
        'some' => 'value',
        'bar' => 'value',
    ];

    public function foo(): void
    {
    }
}

class Some
{
    /**
     * @var string
     */
    private string $foo;
    private string $foo2;

    /**
     * @var mixed
     */
    private mixed $bar;

    public function foo(): void
    {
    }
}

class Some
{
    private const string C = 'C';

    /**
     * Some Comment
     */
    private const string D = 'C';
    private const string A = 'A';

    public function foo(): void
    {
    }
}
