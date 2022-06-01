<?php

$value = 'foo';
$bar = 'foo';
$array = [];

$a = 'foo';
if ($a) {
    $a = 'bar';
}

$a = 'bar';

foreach ($array as $key => $item) {
    $a .= $key;
}
$bar = 'foo';
