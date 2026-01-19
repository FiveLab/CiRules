<?php

$a = 'bar'; // comment here

foreach (['a'] as $e) {

}

$condition = true;
$additional = false;
$data = [];
$someArray = [];

if ($condition) {
    $bar = 'bar';
}

if ($condition) {
    // Some comment here
    $bar = 'bar';
}

if ($condition) {
    /**
     * Extended comment
     */
    $bar = 'bar';
}

if ($condition) {
    if ($additional) {
        $bar = 'foo';
    } else if (true) {
        $bar = 'bar';
    }

    if ($additional) {
        $bar = 'foo';
    } elseif (true) {
        // Some comment
        $bar = 'bar';

        // Some comment
        $bar = 'foo';
    }

    // Some comment here
    $bar = 'foo';
}

foreach ($data as $key => $value) {
    $someArray[] = $value;
}

foreach ($data as $key => $value) {
    // Some comment
    $someArray[] = $value;

    // Some comment
    $bar = 'foo';
}

for ($i = 0; $i < 10; $i++) {
    $someArray[] = $i;
}

for ($i = 0; $i < 10; $i++) {
    /**
     * Some comment
     */
    $someArray[] = $i;

    // Some comment
    $bar = 'bar';
}

while (false) {
    // Some comment
    $bar = 'foo';
}

// Some comment
while (false) {
    $bar = 'foo';
}

do {
    $bar = 'bar';
} while (false);

/**
 * Some comment
 */
do {
    $bar = 'bar';
} while (false);

switch (true) {
    default:
        if (false) {
            $bar = 'bar';
        }

        break;
}

if ($condition) {
    $bar = 'bar';

    break;
}

for ($i = 0; $i < 10; $i++) {
    $someArray[] = $i;

    continue;
}
