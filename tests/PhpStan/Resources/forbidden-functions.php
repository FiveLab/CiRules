<?php

use Acme\func;

\SomeNamespace\func();

func();

$ch = \curl_init();
\curl_setopt($ch, CURLOPT_POST, true);
\curl_exec($ch);

\mb_strlen('foo bar');
