<?php
require __DIR__.'/vendor/autoload.php';
use Src\Core\DBConnection;
use Src\Common\Environment;
Environment::load(__DIR__);

// $env = getenv();
// $pdo = DBConnection::getInstance();