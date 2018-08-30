<?php
use PHPUnit\Framework\TestCase;

class ProviderTest extends TestCase {

    /**
     * @dataProvider data
     */
    public function testA($a, $b, $c)
    {
        $this->assertEquals($a + $b, $c);
    }

    /**
     * @dataProvider data2
     */
    public function testB($a, $b, $c)
    {
        $this->assertEquals($a + $b, $c);
    }

    public function data()
    {
        return [
            [1, 2, 3,],
            [1, 1, 2,],
        ];
    }

    public function data2()
    {
        return [
            'data1' => [1, 2, 3,],
            'data2' => [1, 1, 3,],
        ];
    }

    public function testC()
    {
        $this->assertEquals(1, 1);
        return 6;
    }

    /**
     * @dataProvider data2
     * @depends testC
     */
    public function testD($a, $b, $c, $d)
    {
        $this->assertEquals($d, $a + $b + $c);
    }


    public function data3()
    {
        return [
            'd1' => [1, ],
            'd2' => [2, ],
        ];
    }

    /**
     * @dataProvider data3
     */
    public function testE($a)
    {
        $this->assertEquals(1, 1);
        return $a;
    }

    /**
     * @depends testE
     */
    public function testF($a)
    {
        $this->assertEquals($a, 1);
    }
}
