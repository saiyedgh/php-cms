<?php

// Load environment variables using vlucas/phpdotenv
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$host = getenv('HOST');
$username = getenv('USERNAME');
$password = getenv('PASSWORD');
$database = getenv('DATABASE');

// the following function is not working.
$connect = mysqli_connect($host, $username, $password, $database);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($connect, 'UTF8');
?>
