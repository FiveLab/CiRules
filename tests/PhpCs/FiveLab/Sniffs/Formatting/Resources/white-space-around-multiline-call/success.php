<?php

$res = 23;

$object
    ->child()
        ->method(\sprintf(
            'Foo Bar %s %s %s',
            'some',
            'some',
            'some'
        ))
        ->method('some');

$dom = new \DOMDocument();

function some(\DOMDocument $dom): string
{
    $dom->loadXML(
        '<root/>',
        LIBXML_BIGLINES
    );

    return \sprintf(
        'Success load xml %d',
        $dom->getLineNo()
    );
}

$message = \sprintf('foo bar %s', 'some');

$message = \sprintf(
    'foo %s',
    \sprintf(
        'bar %s',
        \sprintf(
            'some %d',
            1
        )
    )
);

$bar = '0';

$a = new SomeObject(
    new SomeActions([
        new SomeFooBar(
            new SomeObject()
        ),
    ])
);

switch (true) {
    default:
        \sprintf(
            'foo bar',
            $b
        );
        break;
}

#[Assert\NotBlank()]
#[Assert\AtLeastOneOf([
    new Assert\Type('string'),
    new Assert\Type('numeric'),
])]
function withAttributes()
{
    $object = new \StdClass();

    return $object
        ->some([
            'bla' => 'bla',
            'foo' => 'foo',
        ])
        ->some2();
}
