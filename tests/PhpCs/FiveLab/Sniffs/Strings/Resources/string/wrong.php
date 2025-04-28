<?php

$bar = "some string";
$foo = \sprintf("fo bar %s", "some");

$baz = new \stdClass(
    "some param {$foo}"
);
