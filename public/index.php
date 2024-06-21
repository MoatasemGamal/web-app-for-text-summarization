<?php
declare(strict_types=1);
use Core\App;


require_once (dirname(__DIR__) . "/src/config.php");
require_once (SRC_PATH . "vendor/autoload.php");
require_once (CORE_PATH . "helpers.php");

session_name("SESSID");
session_save_path(SESSIONS_PATH);

// Disable warnings
ini_set('display_errors', 'off'); // Turns off display of errors and warnings
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING); // Adjust error reporting level


$configurations = [
    "database" => [
        "dsn" => DSN,
        "username" => DB_USERNAME,
        "password" => DB_PASSWORD,
        "pdo_options" => PDO_OPTIONS
    ],
    "encryption" => [
        "cipher_algo" => CIPHER_ALGO,
        "key" => CIPHER_KEY,
        "vi" => CIPHER_VI,
        "options" => 0
    ]
];

App::init($configurations);

App::$singleton->run();
