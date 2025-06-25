<?php

function some(\DOMDocument $dom): void
{
    $cow = 33;
    $dom->loadXML(
        '<root/>'
    );
    return;
}

$bar = 2;
$message = \sprintf(
    'Foo Bar Some %s',
    'foo'
);
$foo = 3;
