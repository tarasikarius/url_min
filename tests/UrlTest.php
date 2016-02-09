<?php

namespace Tests;

use App\Url;
use App\DB;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    protected $url;

    protected function setUp()
    {
        $this->url = new Url();
    }

    protected function tearDown()
    {
        $this->url = null;
    }

    public function testGetLink()
    {
        $result = $this->url->getlink('asdasd');

        $this->assertFalse($result);
    }

    public function testStoreReturnOnEmptyInput()
    {
        $result = $this->url->store('');

        $this->assertNull($result);
    }

    public function testGetLinkReturnFalseOnNotFound()
    {
        $result = $this->url->getLink(md5('short'));

        $this->assertFalse($result);
    }

    public function testRandomString()
    {
        for ($i = 0; $i < 10; $i++) {
            $string = $this->url->randomString();

            $this->assertTrue(is_string($string));
            $this->assertGreaterThanOrEqual(2, strlen($string));
            $this->assertLessThanOrEqual(4, strlen($string));
        }
    }

    /**
     * @dataProvider dateProvider
     */
    public function testIsExpired($date, $expected)
    {
        $result = $this->url->isExpired($date);

        $this->assertEquals($result, $expected);
    }

    public function dateProvider()
    {
        return [
            ['2015-02-03', true],
            ['2017-02-03', false],
            ['2016-02-09', true]
        ];
    }

    public function testGetDB()
    {
        $result = $this->url->getDB();

        $this->assertTrue($result instanceof DB);
    }
}
