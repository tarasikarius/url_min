<?php

namespace Tests;

use App\Page;

class PageTest extends \PHPUnit_Framework_TestCase
{
    protected $page;

    protected function setUp()
    {
        $this->page = new Page();
    }

    protected function tearDown()
    {
        $this->page = null;
    }

    public function testInputValidate()
    {
        $page = $this->page;
        $input = [
            'url' => '',
            'short_url' => 'short_url',
            'expire_date' => '',
        ];

        $valid_input = $page->inputValidate($input);
        $this->assertTrue(in_array('Url field is required', $page->getErrors()));
    }

    /**
     * @dataProvider shortUrlProvider
     */
    public function testRenderHeader($short, $expected)
    {
        $page = $this->page;
        $page->url_obj->short_url = $short;

        $return = $page->renderHeader();

        $this->assertEquals($expected, $return);
    }

    public function shortUrlProvider()
    {
        return [
            ['', 'Welcome to URL Minifier'],
        ];
    }

    /**
     * @dataProvider uriProvider
     */
    public function testGetUri($request, $expected)
    {
        $_SERVER['REQUEST_URI'] = $request;

        $page = $this->page;
        $uri = $page->getUri();

        $this->assertEquals($expected, $uri);
    }

    public function uriProvider()
    {
        return [
            ['/page', 'page'],
            ['//page', 'page'],
            ['/', false],
        ];
    }
}
