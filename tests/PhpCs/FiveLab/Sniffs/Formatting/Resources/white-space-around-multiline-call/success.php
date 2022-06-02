<?php

$object
    ->method(\sprintf(
        'Foo Bar %s %s %s',
        'some',
        'some',
        'some'
    ))
    ->method('some');

//$dom = new \DOMDocument();
//
//function some(\DOMDocument $dom): string
//{
//    $dom->loadXML(
//        '<root/>',
//        LIBXML_BIGLINES
//    );
//
//    return \sprintf(
//        'Success load xml %d',
//        $dom->getLineNo()
//    );
//}
//
//$message = \sprintf('foo bar %s', 'some');
//
//$message = \sprintf(
//    'foo %s',
//    \sprintf(
//        'bar %s',
//        \sprintf(
//            'some %d',
//            1
//        )
//    )
//);
//
//$bar = '0';
//
//$a = new SomeObject(
//    new SomeActions([
//        new SomeFooBar(
//            new SomeObject()
//        ),
//    ])
//);
//
//switch (true) {
//    default:
//        \sprintf(
//            'foo bar',
//            $b
//        );
//        break;
//}
//
//#[FooBarAttribute()]
//#[SomeAttribute([
//    new Attribute1(),
//    new Attribute2([
//        1,
//        2
//    ]),
//])]
//function withAttributes()
//{
//}
