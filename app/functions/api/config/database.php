<?php 

use Illuminate\Database\Capsule\Manager as Database;

$database = new Database;

$database->addConnection([
    'driver'    => 'mysql',
    'host'      => isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : DB_HOST,
    'database'  => isset($_ENV['DB_NAME']) ? $_ENV['DB_NAME'] : DB_NAME,
    'username'  => isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : DB_USER,
    'password'  => isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : DB_PASSWORD,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci'
]);

$database->setAsGlobal();
$database->bootEloquent();
