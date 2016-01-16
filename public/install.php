<?php

// require composer autoload functions
require __DIR__ . '/../vendor/autoload.php';

// load dotenv library
$dotenv = new Dotenv\Dotenv( __DIR__ . '/..');
$dotenv->load();

use App\InstallDB;

$install = new InstallDB();
$install->createDB();
$install->createTable();



