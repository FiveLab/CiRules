<?php

$a = [];

$min = \min($a);
$max = \max($a);

$message = \sprintf('Min: %s, Max: %s', $min, $max);

$prices = new SomePrices();

$prices->min();
$prices->max();
