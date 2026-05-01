<?php

declare(strict_types=1);

use Phalcon\Mvc\Router;

return static function (Router $router): void {
    $router->addGet('/', [
        'controller' => 'index',
        'action' => 'index',
    ]);
};
