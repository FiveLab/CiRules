<?php

$this
  ->foo();            // expected: 4, actual: 2

$this->foo()->bar()
     ->baz();         // expected: 4, actual: 5

$this
    ->foo()->bar()
  ->baz();            // expected: 4, actual: 2

$this
    ->foo()
         ->bar()      // expected: 4 or 8, actual 9
         ->baz();

$a = $this
   ->foo()            // expected: 4, actual: 3
      ->bar()         // expected: 3 or 7, actual: 6, line before is wrong
   ->baz();           // expected: 6, actual 3, line before is wrong
