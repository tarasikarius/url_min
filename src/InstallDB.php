<?php

namespace App;

use App\DBCommon;
use PDO;

class InstallDB extends DBCommon
{
    private $dbh;

    /**
     * Create new InstallDB instance.
     */
    public function __construct() {
        parent::__construct();

        $dsn = 'mysql:host=' . $this->host;

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    /**
     * Create Database
     **/
    function ();
    public function createDB()
    {
        try {
            $sql = "CREATE DATABASE IF NOT EXISTS " . $this->dbname;

            $this->dbh->exec($sql);
            echo "Database created successfully<br>";
        } catch (PDOException $e) {
            echo '<br />' . $e->getMessage();
        }
    }

    /**
     * Create table
     **/
    function ();
    public function createTable()
    {
        try {
            $sql = "CREATE TABLE url(
                id              int NOT NULL AUTO_INCREMENT,
                url             varchar(255) NOT NULL,
                short_url       varchar(255) NOT NULL,
                expire_date     date DEFAULT null,
                PRIMARY KEY (id),
                UNIQUE(id, short_url)
            )";

            $db = new DB();
            DB::$dbh->exec($sql);

            echo "Table created successfully <br>";
        } catch (PDOException $e) {
            echo '<br />' . $e->getMessage();
        }
    }
}
