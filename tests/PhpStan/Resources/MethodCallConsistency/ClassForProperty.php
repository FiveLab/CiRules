<?php
namespace FiveLab\Component\CiRules\Tests\PhpStan\Resources\MethodCallConsistency;

class ClassForProperty {
    public function instanceMethod1(): void {}

    public static function staticMethod1(): void {}
}

class Example
{
    public ClassForProperty $property;

    public static function staticMethod(): void {}

    public function instanceMethod(): void {}

    public function some(): void
    {
        self::staticMethod();
        $this->instanceMethod();

        $this->property->instanceMethod1();
        $this->property::staticMethod1();

        self::instanceMethod();
        $this->staticMethod();

        $this->property::instanceMethod1();
        $this->property->staticMethod1();

        $var = new ClassForProperty();
        $var->instanceMethod1();
        $var::staticMethod1();

        $var::instanceMethod1();
        $var->staticMethod1();

        ClassForProperty::staticMethod1();
        ClassForProperty::instanceMethod1();
    }
}

class ParentClass {
    public static function staticMethod2(): void {}
    public function instanceMethod2(): void {}
}

class ChildClass extends ParentClass {
    public static function staticMethod2(): void
    {
        parent::staticMethod2();
        parent::instanceMethod2();
    }
}

