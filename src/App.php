<?php

namespace App;

use App\Page;

class App
{

    function __construct()
    {
        $page = new Page();

        // Check if it has some uri
        if ($uri = $page->getUri()) {
            return $page->redirectTo($uri);
        }

        // Check if it's a post request
        if ($_POST) {
            $input = $page->inputValidate($_POST);

            $page->url_obj->store($input);
        }

        $page->renderPage('default');
    }
}
