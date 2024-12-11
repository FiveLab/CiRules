<?php

use Bar;
use Bars;
use SomeFoo;

class Foo
{
    /**
     * @return Bars|Bar[]
     */
    public function run()
    {
    }

    public function some()
    {
        /** @var Bar&SomeFoo $a */
        $a = null;
    }
}
