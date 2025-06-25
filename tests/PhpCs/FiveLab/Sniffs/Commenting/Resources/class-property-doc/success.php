<?php

class MyClass
{
    /**
     * @var int
     */
    private int $foo;

    /**
     * @var string
     */
    private string $bar;

    /**
     * @var array<Some>
     */
    private array $baz;

    /**
     * Construct
     *
     * @param int    $foo
     * @param string $bar
     */
    public function __consturct(int $foo, string $bar)
    {
        /**
         * Some additional comment
         */
        $this->foo = $foo;
        $this->bar = $bar;

        /** @var \DOMDocument $dom */
        $dom = null;
    }
}

/** @var \DOMDocument $b */
$b = null;
