<?php

$dom = new \DOMDocument();
$dom->loadXML('<root/>');
$dom->loadHTML('<html/>');

$file = new \SplFileInfo(__FILE__);
$file->openFile('r')->fread(256);

$dom = new \DOMDocument();
$dom->loadXML(source: '<root/>');
$dom->loadHTML(source: '<html/>');

$file = new \SplFileInfo(__FILE__);
$file->openFile(mode: 'r')->fread(256);
