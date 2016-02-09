<?php

namespace App;

class DBCommon
{
    protected $host;
    protected $dbname;
    protected $user;
    protected $pass;

    /**
     * Create new DBCommon instance.
     */
    public function __construct() {
        $this->host = getenv('DB_HOST');
        $this->dbname = getenv('DB_DATABASE');
        $this->user = getenv('DB_USERNAME');
        $this->pass = getenv('DB_PASSWORD');
    }
}
