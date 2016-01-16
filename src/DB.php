<?php

namespace App;

use PDO;

class DB
{
    private static $dbh;
    private $sql;
    private $attributes;

    /**
     * Create new DB instance.
     */
    public function __construct() {
        if (!self::$dbh) {
            $host = getenv('DB_HOST');
            $db = getenv('DB_DATABASE');
            $user = getenv('DB_USERNAME');
            $pass = getenv('DB_PASSWORD');
            $dsn = 'mysql:dbname=' . $db . ';host=localhost';

            try {
                self::$dbh = new PDO($dsn, $user, $pass);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
        $sth = self::$dbh->prepare($this->sql);
        $sth->execute($this->attributes);
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Create insert sql query
     *
     * @param   string $table, $url, $short_url, $expire_date
     * @return DB
     **/
    public function insert($table, $url, $short_url, $expire_date)
    {
        $this->sql = "INSERT INTO $table (url, short_url, expire_date)
                        VALUES (:url, :short_url, :expire_date)";
        $this->attributes = [
            ':url' => $url,
            ':short_url' => $short_url,
            ':expire_date' => $expire_date,
        ];

        return $this;
    }

    public function delete()
    {
        # code...
    }

}
