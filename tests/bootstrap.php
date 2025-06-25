<?php

// phpcs:ignoreFile

declare(strict_types = 1);

namespace FiveLab\Component\CiRules\Tests;

use PHP_CodeSniffer\Util\Tokens;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../vendor/squizlabs/php_codesniffer/autoload.php';
require_once __DIR__.'/../vendor/nikic/php-parser/lib/PhpParser/compatibility_tokens.php';

\class_exists(Tokens::class);

\define('PHP_CODESNIFFER_VERBOSITY', 0);
\define('PHP_CODESNIFFER_IN_TESTS', true);
\define('PHP_CODESNIFFER_CBF', false);

\PhpParser\defineCompatibilityTokens();
