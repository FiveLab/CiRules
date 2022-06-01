<?php

namespace Sniff\Inheritdoc\Wrong;

class MyDom extends \DOMDocument
{
    /**
     * {@inheritDoc}
     */
    public function loadXML($source, $options = null)
    {
    }

    /**
     * Load HTML
     * {@inheritdoc}
     */
    public function loadHTML($source, $options = 0)
    {
    }

    /**
     * {@inheritdoc}
     * Load some
     */
    public function load($filename, $options = null)
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
