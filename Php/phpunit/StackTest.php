<?php
use PHPUnit\Framework\TestCase;

class StackTest extends TestCase {

//    public static function setUpBeforeClass()
//    {
//        fwrite(STDOUT, __METHOD__ . "\n");
//    }
//
//    protected function setUp()
//    {
//        fwrite(STDOUT, __METHOD__ . "\n");
//    }
//
//    protected function assertPreConditions()
//    {
//        fwrite(STDOUT, __METHOD__ . "\n");
//    }
//
//    public function testOne()
//    {
//        fwrite(STDOUT, __METHOD__ . "\n");
//        $this->assertTrue(true);
//    }
//
//    public function testTwo()
//    {
//        fwrite(STDOUT, __METHOD__ . "\n");
//        $this->assertTrue(false);
//    }
//
//    protected function assertPostConditions()
//    {
//        fwrite(STDOUT, __METHOD__ . "\n");
//    }
//
//    protected function tearDown()
//    {
//        fwrite(STDOUT, __METHOD__ . "\n");
//    }
//
//    public static function tearDownAfterClass()
//    {
//        fwrite(STDOUT, __METHOD__ . "\n");
//    }
//
//    protected function onNotSuccessfulTest(Exception $e)
//    {
//        fwrite(STDOUT, __METHOD__ . "\n");
//        throw $e;
//    }


    public function testSomething()
    {
        // 可选：如果愿意，在这里随便测试点什么。
        $this->assertTrue(true, '这应该已经是能正常工作的。');

        // 在这里停止，并将此测试标记为未完成。
        $this->markTestIncomplete(
            '此测试目前尚未实现。'
        );
    }
}
