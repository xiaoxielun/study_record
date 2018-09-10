<?php
use PHPUnit\Framework\TestCase;

/**
 * @requires extension mysqli
 */
class RequireTest extends TestCase {
    /**
     * @requires PHP 5.3
     */
    public function testConnection()
    {
        // 测试要求有 mysqli 扩展，并且 PHP >= 5.3
        $this->assertEquals(1, 1);
    }

    // ... 所有其他要求有 mysqli 扩展的测试
}