<?php
use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    public function testSomething()
    {
        // 可选：如果愿意，在这里随便测试点什么。
        $this->assertTrue(true, '这应该已经是能正常工作的。');

        // 在这里停止，并将此测试标记为未完成。
        $this->markTestIncomplete(
            '此测试目前尚未实现。'
        );
    }

    public function testA()
    {
        $this->markTestSkipped(
            'MySQLi 扩展不可用。'
        );
    }
}
