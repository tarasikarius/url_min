<?php

namespace App;

use App\DBCommon;
use PDO;

class DB extends DBCommon
{
    public static $dbh;
    private $sql;
    private $attributes;

    /**
     * Create new DB instance.
     */
    public function __construct() {
        if (!self::$dbh) {
            parent::__construct();

            $db_string = 'dbname=' . $this->dbname;
            $dsn = 'mysql:host=' . $this->host . ';' . $db_string;

            try {
                self::$dbh = new PDO($dsn, $this->user, $this->pass);
                self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
    }

    /**
     * Prepare select query
     *
     * @param   string $table, $col
     * @return DB
     **/
    public function select($table, $col = '*')
    {
        $this->sql = "SELECT $col FROM $table";

        return $this;
    }

    /**
     * Add where clause to sql query
     *
     * @param  string $col, $op, $val
     * @return DB
     **/
    public function where($col, $op, $val)
    {
        $this->sql .= " WHERE $col $op :value";
        $this->attributes = [':value' => $val];

        return $this;
    }

    /**
     * Execute sql query and fetch results.
     *
     * @return DB
     **/
    public function get()
    {
        try {
            $sth = self::$dbh->prepare($this->sql);
            $sth->execute($this->attributes);
            $result = $sth->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            echo 'Sorry, errors everywhere(';
        }
    }

    /**
     * Create insert sql query
     *
     * @param   string $table, $url, $short_url, $expire_date
     * @return DB
     **/
    public function insert($table, $url, $short_url, $expire_date)
    {
        try {
            $this->sql = "INSERT INTO $table (url, short_url, expire_date)
                            VALUES (:url, :short_url, :expire_date)";
            $this->attributes = [
                ':url' => $url,
                ':short_url' => $short_url,
                ':expire_date' => $expire_date,
            ];

            $sth = self::$dbh->prepare($this->sql);
            $sth->execute($this->attributes);
        } catch (PDOException $e) {
            echo 'Sorry, errors everywhere(';
        }
    }
}
