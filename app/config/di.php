<?php

declare(strict_types=1);

use Phalcon\Di\Di;
use Phalcon\Di\DiInterface;
use Phalcon\Db\Adapter\Pdo\Postgresql;
use Phalcon\Mvc\View;
use NoteForge\Services\MarkdownService;

return static function (DiInterface $di): void {
    $di->setShared('config', static function () {
        return require dirname(__DIR__) . '/config/config.php';
    });

    $di->setShared('markdown', static function () {
        return new MarkdownService();
    });

    $di->setShared('db', static function () use ($di) {
        /** @var \Phalcon\Config\Config $config */
        $config = $di->getShared('config');

        return new Postgresql([
            'host' => (string)$config->path('db.host'),
            'port' => (int)$config->path('db.port'),
            'dbname' => (string)$config->path('db.dbname'),
            'username' => (string)$config->path('db.username'),
            'password' => (string)$config->path('db.password'),
        ]);
    });

    $di->setShared('view', static function () use ($di) {
        /** @var \Phalcon\Config\Config $config */
        $config = $di->getShared('config');

        $view = new View();
        $view->setViewsDir((string)$config->path('app.viewsDir'));
        $view->setLayout('main');

        return $view;
    });
};
