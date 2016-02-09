<?php

// Include composer autoload functions
require_once "../src/autoload.php";

use App\InstallDB;

$install = new InstallDB();
$install->createDB();
$install->createTable();



