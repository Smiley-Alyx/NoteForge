<?php

declare(strict_types=1);

namespace NoteForge\Controllers;

use Phalcon\Mvc\Controller;

final class IndexController extends Controller
{
    public function indexAction(): void
    {
        $this->view->setVar('title', 'NoteForge');
    }
}
