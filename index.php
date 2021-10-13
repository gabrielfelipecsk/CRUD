<?php
require __DIR__.'/vendor/autoload.php';
use Src\Controllers\DBConnection;
use Src\Common\Environment;
Environment::load(__DIR__);

$env = getenv();
print_r($env);
// $pdo = DBConnection::getInstance();