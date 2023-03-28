<?php

namespace Sniff\Inheritdoc\Success;

include_once __DIR__.'/success-trait.php';

class MyDom extends \DOMDocument
{
    use MyTrait;

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
