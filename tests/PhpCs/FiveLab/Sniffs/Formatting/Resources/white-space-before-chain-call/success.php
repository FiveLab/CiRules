<?php

$this->foo();

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

$a = $this
    ->foo()
        ->bar(
            $b->foo()
                ->bar()
                ->baz()
        )
    ->baz();

return $this->foo()
    ->bar(
        $a->foo()
    )
    ->baz();

self::foo()->foo()
    ->bar(
        $a->foo()
    )
    ->baz();

    $a = $this
        ->foo()

        ->bar();

    $a = $this
        ->foo()
            ->bar()
        ->baz();
