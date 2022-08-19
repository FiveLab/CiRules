## Russia has become a terrorist state.

<div style="font-size: 2em; color: #d0d7de;">
    <span style="background-color: #54aeff">&nbsp;#StandWith</span><span style="background-color: #d4a72c">Ukraine&nbsp;</span>
</div>

CI Rules
========

* Extends `escapestudios/symfony2-coding-standard` code style rules with added our custom rules.
* Add custom rules for `phpstan`.


Development
-----------

For easy development you can use the `Docker`.

```shell
docker build -t ci-rules .
docker run -it -v $(pwd):/code --name ci-rules ci-rules bash

```

After success run and attach to container you must install vendors:

```shell
composer update
```

Before create the PR or merge into develop, please run next commands for validate code:

```shell
./bin/phpunit

./bin/phpcs --config-set show_warnings 0
./bin/phpcs --standard=vendor/escapestudios/symfony2-coding-standard/Symfony/ src/
./bin/phpcs --standard=tests/phpcs-ruleset.xml tests/

```

