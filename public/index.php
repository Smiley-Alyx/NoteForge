<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Phalcon\Autoload\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Http\Response\ResponseInterface;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Router;

if (is_file(dirname(__DIR__) . '/.env')) {
    Dotenv::createImmutable(dirname(__DIR__))->safeLoad();
}

$loader = new Loader();
$loader->setNamespaces([
    'NoteForge\\Controllers' => dirname(__DIR__) . '/app/Controllers/',
    'NoteForge\\Models' => dirname(__DIR__) . '/app/Models/',
    'NoteForge\\Services' => dirname(__DIR__) . '/app/Services/',
]);
$loader->register();

$di = new FactoryDefault();
(require dirname(__DIR__) . '/app/config/di.php')($di);

$router = new Router(false);
$router->removeExtraSlashes(true);
$router->setDefaultNamespace('NoteForge\\Controllers');
(require dirname(__DIR__) . '/app/config/routes.php')($router);
$di->setShared('router', $router);

$app = new Application($di);

try {
    /** @var ResponseInterface $response */
    $response = $app->handle($_SERVER['REQUEST_URI'] ?? '/');
    $response->send();
} catch (Throwable $e) {
    http_response_code(500);
    echo 'Application error: ' . $e->getMessage();
}
