<?php

declare(strict_types=1);

use Phalcon\Mvc\Router;

return function (Router $router): void {
    $router->addGet('/', [
        'controller' => 'notes',
        'action' => 'index',
    ]);

    $router->addGet('/notes', [
        'controller' => 'notes',
        'action' => 'index',
    ]);

    $router->addGet('/notes/create', [
        'controller' => 'notes',
        'action' => 'create',
    ]);

    $router->addPost('/notes', [
        'controller' => 'notes',
        'action' => 'store',
    ]);

    $router->addGet('/notes/{id:[0-9]+}', [
        'controller' => 'notes',
        'action' => 'show',
    ]);

    $router->addGet('/notes/{id:[0-9]+}/edit', [
        'controller' => 'notes',
        'action' => 'edit',
    ]);

    $router->addPost('/notes/{id:[0-9]+}', [
        'controller' => 'notes',
        'action' => 'update',
    ]);

    $router->addPost('/notes/{id:[0-9]+}/delete', [
        'controller' => 'notes',
        'action' => 'delete',
    ]);
};
