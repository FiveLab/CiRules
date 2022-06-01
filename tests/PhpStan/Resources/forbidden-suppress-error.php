<?php


$a = [1, 2, 3];

[$t, $y, $x] = $a;
list($t, $y, $x) = $a;

@\trigger_error('Foo Bar', E_USER_DEPRECATED);

$dom = new \DOMDocument();
@$dom->loadXML('<root/>');
@$dom->loadHTML('<html/>');

@\unlink(__FILE__.'.missed');
