<?php

// elseif
$a = $b = $c = true;

if ($a) {
} elseif (($a && $b) || $c) {
}

// for
$a = 0;

for ($i = 0; $i < $a; $i++) {
}

// foreach
$a = [];

foreach ($a as $b => $c) {
}

// if
$a = $b = $c = true;

if (($a && $b) || $c) {
}

// ternary
$a = true;
$b = $a ? 'yes' : 'no';

function c(): bool
{
    $a = true;

    return $a ? 'yes' : 'no';
}

\sprintf(
    'Variable is true: %s',
    $a ? 'yes' : 'no'
);

$c = $a ?: \sprintf(
    'Some %s',
    $b
);

$d = $a ? 'Yes' : \sprintf(
    'Some %s',
    $b
);

// while
$a = $b = $c = true;

while (($a && $b) || $c) {
}
