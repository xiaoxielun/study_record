<?php
use PHPUnit\Framework\TestCase;

class ArrayWeakComparisonTest extends TestCase {

    public function testA()
    {
        $this->assertEquals([1, 2, 3, 4, ], ['1', 2, 23, 4]);
    }
}