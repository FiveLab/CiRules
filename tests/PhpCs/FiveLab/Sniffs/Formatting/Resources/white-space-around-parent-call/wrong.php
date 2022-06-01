<?php

class MyDom extends \DOMDocument
{
    public function loadXML($source, $options = null)
    {
        $a = 1;
        parent::loadXML($source, $options);
    }

    public function loadHTML($source, $options = 0)
    {
        $a = 1;
        return parent::loadHTML($source, $options);
    }

    public function registerNodeClass($baseClass, $extendedClass)
    {
        parent::registerNodeClass($baseClass, $extendedClass);
        $a = 1;
    }
}
