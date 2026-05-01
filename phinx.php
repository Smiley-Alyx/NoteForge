<?php

declare(strict_types=1);

use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

if (is_file(__DIR__ . '/.env')) {
    Dotenv::createImmutable(__DIR__)->safeLoad();
}

$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = (int)(getenv('DB_PORT') ?: 5432);
$dbname = getenv('DB_NAME') ?: 'noteforge';
$user = getenv('DB_USER') ?: 'noteforge';
$pass = getenv('DB_PASS') ?: 'noteforge';

return [
    'paths' => [
        'migrations' => __DIR__ . '/migrations',
        'seeds' => __DIR__ . '/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'default',
        'default' => [
            'adapter' => 'pgsql',
            'host' => $host,
            'port' => $port,
            'name' => $dbname,
            'user' => $user,
            'pass' => $pass,
            'charset' => 'utf8',
        ],
    ],
];
