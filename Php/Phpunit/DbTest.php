<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

class DbTest extends TestCase {

    use TestCaseTrait;

    static $conn = null;

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {

        if(self::$conn == null)
        {
            $pdo = new PDO('mysql:dbname=test;host=localhost', 'root', 'root');
            self::$conn = $this->createDefaultDBConnection($pdo, 'user');
        }
        return self::$conn;
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        $va = $this->createXMLDataSet(dirname(__FILE__) . '/data.xml');
        return $va;
    }

    public function test1()
    {
        $dataSet = $this->getConnection()->createDataSet()->getTable('user');
        $queryTable = $this->getConnection()->createQueryTable('user', 'SELECT * FROM user');
        $va = $this->getDataSet()->getTable('user');
        $this->assertTablesEqual($dataSet, $va);
    }

    public function test2()
    {
        $this->assertEquals(1, $this->getConnection()->getRowCount('user'));
    }

    public function test3()
    {
        $expectedDataSet = $this->getDataSet();
        $dataSet = $this->getConnection()->createDataSet(['user']);

        $this->assertDataSetsEqual($expectedDataSet, $dataSet);
    }
}
