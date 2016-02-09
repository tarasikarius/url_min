<?php

namespace Tests;

use App\DB;

class DBTest extends \PHPUnit_Framework_TestCase
{
    protected $db;

    public function testDbhType()
    {
        $this->assertTrue(DB::$dbh instanceof \PDO);
    }

    /**
     * @dataProvider selectDataProvider
     */
    public function testSelect($expected_sql, $col)
    {
        $table = $this->table;

        $this->db->select($table, $col);

        $sql = $this->getSqlProperty();

        $this->assertEquals($expected_sql, $sql);

        return $sql;
    }

    public function selectDataProvider()
    {
        return [
            ['SELECT * FROM url', '*'],
            ['SELECT id FROM url', 'id'],
        ];
    }

    /**
     * @dataProvider whereDataProvider
     */
    public function testWhere($expected_sql, $col, $op, $val)
    {
        $this->db->where($col, $op, $val);
        $attr = $this->getProperty('attributes')->getValue($this->db);
        $sql = $this->getSqlProperty();

        $this->assertEquals($expected_sql, $sql);
        $this->assertEquals($val, $attr[':value']);
    }

    public function whereDataProvider()
    {
        return [
            [' WHERE id > :value', 'id', '>', '1'],
            [' WHERE short_url = :value', 'short_url', '=', 'abc'],
        ];
    }

    /**
     * @dataProvider insertDataProvider
     * @covers DB::insert
     * @covers DB::get
     */
    public function testInsert($url, $short_url, $expire_date)
    {
        $table = $this->table;
        DB::$dbh->query('DELETE FROM ' . $table);

        $this->db->insert($table, $url, $short_url, $expire_date);

        $result = $this->db
            ->select($this->table, '*')
            ->where('short_url', '=', $short_url)
            ->get();

        $this->assertEquals($url, $result['url']);
        $this->assertEquals($short_url, $result['short_url']);
    }

    public function insertDataProvider()
    {
        return [
            ['http://example.com', 'test_short', '2018-01-01'],
        ];
    }

    /**
     * @expectedException PDOException
     */
    public function testInsertFails()
    {
        $this->db->insert(null, null, null, null);
    }

    /**
     * Helps to get DB::sql property value.
     *
     * @return string
     */
    protected function getSqlProperty()
    {
        return $this->getProperty('sql')->getValue($this->db);
    }

    /**
     * Get access to protected and private properties
     *
     * @return ReflectionProperty
     */
    protected static function getProperty($name) {
        $class = new \ReflectionClass(DB::class);
        $property = $class->getproperty($name);
        $property->setAccessible(true);

        return $property;
    }

    protected function setUp()
    {
        $this->db = new DB();
        $this->table = 'url';
    }

    protected function tearDown()
    {
        $this->db = null;
    }
}
