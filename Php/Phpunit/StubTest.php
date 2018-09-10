<?php
use PHPUnit\Framework\TestCase;

class StubTest extends TestCase {
    public function testStub()
    {
        // 为 SomeClass 类创建桩件。
        $stub = $this->createMock(SomeClass::class);

        // 配置桩件。
        $stub->method('doSomething')
            ->willReturn('foo');

        // 现在调用 $stub->doSomething() 将返回 'foo'。
        $this->assertEquals('foo', $stub->doSomething());
    }

    public function testArg()
    {
        $stub = $this->createMock(SomeClass::class);

        $stub->method('doSomething')->will($this->returnArgument(0));

        $this->assertEquals('foo', $stub->doSomething('foo', 'x'));
    }

    public function testObj()
    {
        $stub = $this->createMock(SomeClass::class);

        $stub->method('doSomething')->will($this->returnSelf());

        $this->assertEquals($stub, $stub->doSomething());
    }

    public function testArgTar()
    {
        $stub = $this->createMock(SomeClass::class);
        $stub->method('doSomething')->will($this->returnValueMap(
            [
                ['a', 'b'],
                ['c', 'd'],
                ['1', '2', '3'],]
        ));

        $this->assertEquals('b', $stub->doSomething('a'));
        $this->assertEquals('3', $stub->doSomething('1', '2'));
    }

    public function testCall()
    {
        $stub = $this->createMock(SomeClass::class);
        $stub->method('doSomething')->will($this->returnCallback('strlen'));

        $this->assertEquals('1', $stub->doSomething(2));
    }

    public function testFor()
    {
        $stub = $this->createMock(SomeClass::class);
        $stub->method('doSomething')->will($this->onConsecutiveCalls(2, 3, 4, 5));

        $this->assertEquals(2, $stub->doSomething());
        $this->assertEquals(3, $stub->doSomething());
    }

    public function testThrow()
    {
//        $this->expectException('exception');
        $stub = $this->createMock(SomeClass::class);
        $stub->method('doSomething')->will($this->throwException(new Exception()));

        $stub->doSomething();
    }
}

class SomeClass
{
    public function doSomething()
    {
        // 随便做点什么。
    }
}
