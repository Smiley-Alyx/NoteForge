<?php

declare(strict_types=1);

use Phalcon\Config\Config;

return new Config([
    'app' => [
        'env' => getenv('APP_ENV') ?: 'local',
        'debug' => (bool)(getenv('APP_DEBUG') ?: false),
        'baseUri' => getenv('APP_BASE_URI') ?: '/',
        'viewsDir' => dirname(__DIR__) . '/views/',
    ],
    'db' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => (int)(getenv('DB_PORT') ?: 5432),
        'dbname' => getenv('DB_NAME') ?: 'noteforge',
        'username' => getenv('DB_USER') ?: 'noteforge',
        'password' => getenv('DB_PASS') ?: 'noteforge',
    ],
]);
