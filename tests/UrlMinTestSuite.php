<?php

namespace Tests;

use Tests\PageTest;
use Tests\UrlTest;
use App\Page;

class UrlMinTestSuite extends \PHPUnit_Framework_TestSuite
{
    // protected $sharedPage;

    public static function suite()
    {
        $suite = new UrlMinTestSuite('UrlMinTests');

        $suite->addTestSuite(PageTest::class);
        $suite->addTestSuite(UrlTest::class);

        return $suite;
    }

    // protected function setUp()
    // {
    //     $this->sharedPage = new Page();
    // }

    // protected function tearDown()
    // {
    //     $this->sharedPage = null;
    // }
}
