<?php

namespace Sniff\Inheritdoc\Success;

include_once __DIR__.'/success-trait.php';
include_once __DIR__.'/success-interface.php';

class MyDom extends \DOMDocument implements MyInterface
{
    use MyTrait;

    /**
     * {@inheritdoc}
     */
    public function doSomething(string $a, ?string $b): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function doSomethingSecond(string $a): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function doSomethingThird(): null|array
    {
    }

    /**
     * {@inheritdoc}
     */
    public function loadXML($source, $options = null)
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function someAction(): void
    {
    }
}
