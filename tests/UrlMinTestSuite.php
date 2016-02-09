<?php

namespace Tests;

use Tests\PageTest;
use Tests\UrlTest;
use App\Page;

class UrlMinTestSuite extends \PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new UrlMinTestSuite('UrlMinTests');

        $suite->addTestSuite(PageTest::class);
        $suite->addTestSuite(UrlTest::class);
        $suite->addTestSuite(DBTest::class);

        return $suite;
    }
}
