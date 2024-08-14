<?php
require 'vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('DATABASE_HOST', $_ENV['DATABASE_HOST']);
define('DATABASE_USERNAME', $_ENV['DATABASE_USERNAME']);
define('DATABASE_PASSWORD', $_ENV['DATABASE_PASSWORD']);
define('DATABASE_NAME', $_ENV['DATABASE_NAME']);
define('DATABASE_PORT', $_ENV['DATABASE_PORT']);

try {
    $conn = new PDO("mysql:host=" . DATABASE_HOST . ";port=" . DATABASE_PORT. ";dbname=" . DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}