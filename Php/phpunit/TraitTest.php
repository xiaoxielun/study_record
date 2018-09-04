<?php
use PHPUnit\Framework\TestCase;

trait ATrait {

    abstract public function x();
}

class TraitTest extends TestCase {

    public function testXXX()
    {

        $stub = $this->getMockForTrait(ATrait::class);

        $stub->expects($this->any())
            ->method('x')
            ->will($this->returnValue(true));

        $this->assertTrue($stub->x());
    }
}

abstract class AbstractClass
{
    public function concreteMethod()
    {
        return $this->abstractMethod();
    }

    public abstract function abstractMethod();
}

class AbstractClassTest extends TestCase
{
    public function testConcreteMethod()
    {
        $stub = $this->getMockForAbstractClass(AbstractClass::class);

        $stub->expects($this->any())
            ->method('abstractMethod')
            ->will($this->returnValue(true));

        $this->assertTrue($stub->concreteMethod());
    }
}