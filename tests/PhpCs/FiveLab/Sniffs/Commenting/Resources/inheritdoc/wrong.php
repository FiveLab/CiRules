<?php

namespace Sniff\Inheritdoc\Wrong;

class MyDom extends \DOMDocument
{
    /**
     * {@inheritDoc}
     */
    public function loadXML(string $source, int $options = 0): bool
    {
    }

    /**
     * Load HTML
     * {@inheritdoc}
     */
    public function loadHTML(string $source, int $options = 0): bool
    {
    }

    /**
     * {@inheritdoc}
     * Load some
     */
    public function load(string $filename, int $options = 0): bool
    {
    }

    /**
     * {@inheritdoc}
     */
    public function bar()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
    }
}
