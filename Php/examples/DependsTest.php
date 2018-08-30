<?php
use PHPUnit\Framework\TestCase;

class DependsTest extends TestCase {

    public function testA()
    {
        $a = 10;
        $this->assertEquals($a, 10);
        return $a;
    }

    /**
     * @depends testA
     */
    public function testB($a)
    {
        $this->assertEquals(10, 10);
        return $a;
    }

    /**
     * @depends testB
     */
    public function testC($a)
    {
        $this->assertEquals($a, 10);
    }

    public function testD()
    {
        $b = 11;
        $this->assertEquals($b, 11);
        return $b;
    }

    /**
     * @depends testA
     * @depends testD
     */
    public function testE($a, $b)
    {
        $this->assertEquals($a + $b, 21);
    }
}
