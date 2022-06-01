<?php

$dom = new \DOMDocument();
$dom->loadXML('<root/>');
$dom->loadHTML('<html/>');

$file = new \SplFileInfo(__FILE__);
$file->getPath();
$file->getSize();
