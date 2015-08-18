<?php

// Include the Composer autoloader, everything else is loaded automatically.
require __DIR__ . '/../vendor/autoload.php';

// Load the configuration file
Dotenv::load(__DIR__ . '/../conf/', 'conf.env');

// Specify the required configuration variables.
Dotenv::required(array(
    'SLURP_DB_HOST',
    'SLURP_DB_PORT',
    'SLURP_DB_NAME',
    'SLURP_DB_USER',
    'SLURP_DB_PASS'
));

// Initialise a database manager.
$db = new Illuminate\Database\Capsule\Manager;

// Add the connection to the manager. Connection itself is lazy, and happens when needed.
$db->addConnection([
    'driver'    => 'pgsql',
    'host'      => $_ENV['SLURP_DB_HOST'],
    'port'      => $_ENV['SLURP_DB_PORT'],
    'database'  => $_ENV['SLURP_DB_NAME'],
    'username'  => $_ENV['SLURP_DB_USER'],
    'password'  => $_ENV['SLURP_DB_PASS'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci'
]);
