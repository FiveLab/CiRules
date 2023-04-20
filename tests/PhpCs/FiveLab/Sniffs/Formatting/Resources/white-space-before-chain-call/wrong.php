<?php

$this
  ->foo();

$this->foo()->bar()
     ->baz();

$this
    ->foo()->bar()
  ->baz();

$this
    ->foo()
         ->bar()
         ->baz();

$a = $this
   ->foo()
      ->bar()
   ->baz();
