<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv( __DIR__ . '/..');
$dotenv->load();


$page = new App\Page();
$page->render();
