<?php
namespace App;

use App\Url;

class Page
{
    protected $url;
    protected $short_url;
    protected $expire_date;

    /**
     * Generate new Url instance.
     *
     **/
    public function __construct()
    {
        if ($_POST) {
            $this->url = isset($_POST['url']) ? $_POST['url'] : '';
            $this->short_url = isset($_POST['short_url']) ? $_POST['short_url'] : '';
            $this->expire_date = isset($_POST['expire_date']) ? $_POST['expire_date'] : '';

            $url_obj = new Url();
            $url_obj->store($this->url, $this->short_url, $this->expire_date);

            $this->short_url = $url_obj->short_url;
        }
    }

    /**
     * Render form or redirect to short url's full link
     *
     **/
    public function render()
    {
        if (!$uri = $this->getUri()) {
            require "../tpl/default.php";
        }
        else {
            $url_obj = new Url();

            if ($link = $url_obj->getLink($uri)) {
                $url = $link['url'];
                $date = $link['expire_date'];

                if (!$url_obj->isExpired($date)) {
                    header("Location: $url",TRUE,302);
                }
            }
            require "../tpl/404.php";
        }

    }

    /**
     * Generate page header
     *
     * @return string
     **/
    public function renderHeader()
    {
        if (!empty($this->short_url)) {
            return 'Your Result: <a href=' . $this->short_url . ' target="blank">
                http://' . $_SERVER['HTTP_HOST'] . '/' . $this->short_url . '
            </a>';
        }

        return 'Welcome to URL Minifier';
    }

    /**
     * Get current uri.
     *
     * @return void
     **/
    public function getUri()
    {
        $string = $_SERVER['REQUEST_URI'];

        if (!strlen($string) > 1) {
            return FALSE;
        }

        $uri = ltrim($string, '/');

        return $uri;
    }

}
