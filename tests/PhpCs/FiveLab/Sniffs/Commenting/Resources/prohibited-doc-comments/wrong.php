<?php

class Some {

    /**
     * Some comment
     */
    public const FOO = 'foo';

    public function bar(): void
    {
        /**
         * Some comment
         */
        $foo2 = 'foo';

        $func = static function () {

            /**
             * Some comment
             */
            $foo2 = 'bar';
        };

        /**
         * Some comment
         */
        if ($foo2 === 'bar') {}

        /**
         * Some comment
         */
        return;
    }
}
