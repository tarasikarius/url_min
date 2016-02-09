<?php

namespace App;

use App\DB;

class Url
{
    public $short_url;
    public $url;
    public $expire_date;
    private $db;
    private $table = 'url';

    /**
     * Create new Url instance.
     *
     * @param array $data
     */
    public function __construct()
    {
        $this->db = new DB();
    }

    public function store($input)
    {
        if (empty($input)) {
            return;
        }

        extract($input);

        $this->url = $url;
        $this->expire_date = $expire_date;

        if (!empty($url)) {
            $this->short_url = $this->setShortUrl($short_url);

            $this->db->insert($this->table, $url, $this->short_url, $expire_date);
        }
    }

    public function setShortUrl($short_url = '')
    {
        if (!empty($short_url)) {
            return $short_url;
        }

        for ($i = TRUE; $i == TRUE;) {
            $short_url = $this->randomString();
            $i = $this->isShortUrlExists($short_url);
        }

        return $short_url;
    }

    /**
     * Check if given short_url already exists.
     *
     * @param  string $short_url
     * @return boolean
     */
    public function isShortUrlExists($short_url)
    {
        $result = $this->db->select('url', 'id')->where('short_url', '=', $short_url)->get();
        if ($result) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Get short_url corresponding link if it's exists.
     *
     * @param  string $short_url
     * @return void
     */
    public function getLink($short_url)
    {
        $db = $this->getDB();
        $result = $db
            ->select('url', 'url, expire_date')
            ->where('short_url', '=', $short_url)
            ->get()
        ;

        if ($result) {
            return $result;
        }

        return false;
    }

    /**
     * Generate random 2-4 characters string.
     *
     * @return string
     */
    public function randomString()
    {
        $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));

        return substr(str_shuffle(implode($chars)), 0, rand(2, 4));
    }

    /**
     * Check if link is expired.
     *
     * @return boolean
     */
    public function isExpired($date)
    {
        $today = date("Y-m-d");

        if ($today >= $date && $date != '0000-00-00') {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Get DB object
     *
     * @return App\DB
     */
    public function getDB()
    {
        return $this->db;
    }
}
