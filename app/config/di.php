<?php

declare(strict_types=1);

use Phalcon\Di\Di;
use Phalcon\Di\DiInterface;
use Phalcon\Db\Adapter\Pdo\Postgresql;
use Phalcon\Mvc\View;
use Phalcon\Url;
use NoteForge\Services\MarkdownService;

return function (DiInterface $di): void {
    $di->setShared('config', function () {
        return require dirname(__DIR__) . '/config/config.php';
    });

    $di->setShared('url', function () use ($di) {
        /** @var \Phalcon\Config\Config $config */
        $config = $di->getShared('config');

        $url = new Url();
        $url->setBaseUri((string)$config->path('app.baseUri'));

        return $url;
    });

    $di->setShared('markdown', function () {
        return new MarkdownService();
    });

    $di->setShared('db', function () use ($di) {
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

    $di->setShared('view', function () use ($di) {
        /** @var \Phalcon\Config\Config $config */
        $config = $di->getShared('config');

        $view = new View();
        $view->setViewsDir((string)$config->path('app.viewsDir'));
        $view->setLayout('main');

        return $view;
    });
};
