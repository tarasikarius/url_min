<?php
namespace App;

use App\Url;

class Page
{
    public $url_obj;
    protected $errors = [];

    /**
     * Generate new Url instance.
     */
    public function __construct()
    {
        $this->url_obj = new Url();
    }

    /**
     * Validate form input.
     */
    public function inputValidate(array $input)
    {
        /**
         * нужно ли выкидывать исключение если не масив??
         */
        if (!$input['url']) {
            $this->errors[] = 'Url field is required';
        }

        if ($this->url_obj->isShortUrlExists($input['short_url'])) {
            $this->errors[] = 'Sorry, given Short url already taken. Please chose another one.';
        }

        $input['short_url'] = $input['short_url'] ? $input['short_url'] : '';
        $input['expire_date'] = $input['expire_date'] ? $input['expire_date'] : '';

        return $input;
    }

    /**
     * Render given page.
     */
    public function renderPage($page = '404')
    {
        $path = '../tpl/' . $page . '.php';

        if (!file_exists($path)) {
            require_once '../tpl/404.php';

            return;
        }

        require_once $path;
    }

    /**
     * Redirect to given uri.
     */
    public function redirectTo($uri)
    {
        $url_obj = $this->url_obj;

        if (!$link = $url_obj->getLink($uri)) {
            return $this->renderPage($uri);
        }

        $url = $link['url'];
        $date = $link['expire_date'];

        if (!$url_obj->isExpired($date)) {
            header("Location: $url", TRUE, 302);
        }

        $this->renderPage();
    }

    /**
     * Generate page header
     *
     * @return string
     */
    public function renderHeader()
    {
        $short_url = $this->url_obj->short_url;
        if (!empty($short_url)) {
            return 'Your Result: <a href="' . $short_url . '" target="blank">
                http://' . $_SERVER['HTTP_HOST'] . '/' . $short_url . '
            </a>';
        }

        return 'Welcome to URL Minifier';
    }

    /**
     * Get current uri.
     *
     * @return void
     */
    public function getUri()
    {
        $string = $_SERVER['REQUEST_URI'];

        if (!strlen($string) > 1) {
            return FALSE;
        }

        $uri = ltrim($string, '/');

        return $uri;
    }

    /**
     * Get current short url.
     *
     * @return string
     */
    public function getShortUrl()
    {
        return $this->url_obj->short_url;
    }

    /**
     * Get current url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url_obj->url;
    }

    /**
     * Get current expire date.
     *
     * @return string
     */
    public function getExpireDate()
    {
        return $this->url_obj->expire_date;
    }

    /**
     * Get errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

}
