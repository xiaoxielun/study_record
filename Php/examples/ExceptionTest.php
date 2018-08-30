<?php
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase {

    public function testException()
    {
        $this->expectException('Exception');
        throw new Exception();
    }

    public function testException2()
    {
        $this->expectException(InvalidArgumentException::class);
    }

    /**
     * @expectedException PHPUnit\Framework\Error\Error
     */
    public function testFailingInclude()
    {
        include 'not_existing_file.php';
    }

    public function testOutput()
    {
        echo 1234;
        $this->expectOutputString('123');
    }
}
