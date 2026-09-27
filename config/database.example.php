<?php

define('DB_HOST', 'your_database_host');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_database_password');

function getDBConnection(): PDO
{
    static $pdo = null;

    if ($pdo === null) {

        $dsn = 'mysql:host=' . DB_HOST .
               ';dbname=' . DB_NAME .
               ';charset=utf8mb4';

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $pdo = new PDO(
            $dsn,
            DB_USER,
            DB_PASS,
            $options
        );
    }

    return $pdo;
}
