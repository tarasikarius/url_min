<?php

namespace App;

use App\DB;

class Url
{
    public $short_url;
    private $db;
    private $table = 'url';

    /**
     * Create new Url instance.
     *
     * @param array $data
     **/
    public function __construct()
    {
        $this->db = new DB();
    }

    public function store($url, $short_url, $expire_date)
    {
        // check if url field is not empty
        if (empty($url)) {
            die('Url field is required');
        }

        if (!empty($short_url)) {
            if (!$this->checkShortUrl($short_url)) {
                die('Sorry, given Short url already taken. Please chose another one.');
            }
        }
        else {
            for ($i=FALSE; $i==FALSE;) {
                $short_url = $this->randomString();
                $i = $this->checkShortUrl($short_url);
            }
        }

        $this->db->insert($this->table, $url, $short_url, $expire_date);
        $this->short_url = $short_url;
    }

    /**
     * Check if given short_url already exists.
     *
     * @param  string $short_url
     * @return boolean
     **/
    public function checkShortUrl($short_url)
    {
        $result = $this->db->select('url', 'id')->where('short_url', '=', $short_url)->get();
        if ($result) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Get short_url corresponding link if it's exists.
     *
     * @param  string $short_url
     * @return void
     **/
    public function getLink($short_url)
    {
        $result = $this->db->select('url', 'url, expire_date')->where('short_url', '=', $short_url)->get();
        if ($result) {
            return $result;
        }

        return FALSE;
    }

    /**
     * Generate random 2-4 characters string.
     *
     * @return string
     **/
    public function randomString()
    {
        $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        return substr(str_shuffle(implode($chars)), 0, rand(2, 4));
    }

    /**
     * Check if link is expired.
     *
     * @return boolean
     **/
    public function isExpired($date)
    {
        if ($date != '0000-00-00') {
            $today = date("Y-m-d");
            if ($today >= $date) {
                return TRUE;
            }
        }

        return FALSE;
    }
}
