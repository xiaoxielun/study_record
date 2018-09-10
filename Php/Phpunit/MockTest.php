<?php
use PHPUnit\Framework\TestCase;

class SubjectTest extends TestCase
{
    public function testObserversAreUpdated()
    {
        // 为 Observer 类建立仿件对象，只模仿 update() 方法。
        $observer = $this->getMockBuilder(Observer::class)
            ->setMethods(['update'])
            ->getMock();

        // 建立预期状况：update() 方法将会被调用一次，
        // 并且将以字符串 'something' 为参数。
        $observer->expects($this->once())
            ->method('update')
            ->with($this->equalTo('something'));

        // 创建 Subject 对象，并将模仿的 Observer 对象连接其上。
        $subject = new Subject('My subject');
        $subject->attach($observer);

        // 在 $subject 对象上调用 doSomething() 方法，
        // 预期将以字符串 'something' 为参数调用
        // Observer 仿件对象的 update() 方法。
        $subject->doSomething();
    }

    public function testErrorReported()
    {
        // 为 Observer 类建立仿件，对 reportError() 方法进行模仿
        $observer = $this->getMockBuilder(Observer::class)
            ->setMethods(['reportError'])
            ->getMock();

        $observer->expects($this->once())
            ->method('reportError')
            ->with(
                $this->greaterThan(0),
                $this->stringContains('Something'),
                $this->anything()
            );

        $subject = new Subject('My subject');
        $subject->attach($observer);

        // doSomethingBad() 方法应当会通过（observer的）reportError()方法
        // 向 observer 报告错误。
        $subject->doSomethingBad();
    }

    public function testFunctionCalledTwoTimesWithSpecificArguments()
    {
        $mock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['set'])
            ->getMock();

        $mock->expects($this->exactly(2))
            ->method('set')
            ->withConsecutive(
                [$this->equalTo('foo'), $this->greaterThan(0)],
                [$this->equalTo('bar'), $this->greaterThan(0)]
            );

        $mock->set('foo', 21);
        $mock->set('bar', 48);
    }

    public function testxxx()
    {
        // 为 Observer 类建立仿件，模仿 reportError() 方法
        $observer = $this->getMockBuilder(Observer::class)
            ->setMethods(['reportError'])
            ->getMock();

        $observer->expects($this->once())
            ->method('reportError')
            ->with($this->greaterThan(0),
                $this->stringContains('Something'),
                $this->callback(function($subject){
                    return is_callable([$subject, 'getName']) &&
                        $subject->getName() == 'My subject';
                }));

        $subject = new Subject('My subject');
        $subject->attach($observer);

        // doSomethingBad() 方法应当会通过（observer的）reportError()方法
        // 向 observer 报告错误。
        $subject->doSomethingBad();
    }

    public function testIdenticalObjectPassed()
    {
        $expectedObject = new stdClass;

        $mock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['foo'])
            ->getMock();

        $mock->expects($this->once())
            ->method('foo')
            ->with($this->identicalTo($expectedObject));

        $mock->foo($expectedObject);
    }

    public function testIdenticalObjectPassed2()
    {
        $expectedObject = new stdClass;
        $cloneArguments = true;

        $mock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['foo'])
            ->enableArgumentCloning()
            ->getMock();

        // 现在仿件将对参数进行克隆，因此 identicalTo 约束将会失败。
        $mock->expects($this->once())
        ->method('foo')
        ->with($this->identicalTo($expectedObject));

        $mock->foo($expectedObject);
    }
}

class Subject
{
    protected $observers = [];
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function attach(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    public function doSomething()
    {
        // 做点什么
        // ...

        // 通知观察者发生了些什么
        $this->notify('something');
    }

    public function doSomethingBad()
    {
        foreach ($this->observers as $observer) {
            $observer->reportError(42, 'Something bad happened', $this);
        }
    }

    protected function notify($argument)
    {
        foreach ($this->observers as $observer) {
            $observer->update($argument);
        }
    }

    // 其他方法。
}

class Observer
{
    public function update($argument)
    {
        // 做点什么。
    }

    public function reportError($errorCode, $errorMessage, Subject $subject)
    {
        // 做点什么。
    }

    // 其他方法。
}
