<?php

declare(strict_types=1);

namespace NoteForge\Controllers;

use NoteForge\Models\Note;
use Phalcon\Http\Request\RequestInterface;
use Phalcon\Mvc\Controller;
use Throwable;

final class NotesController extends Controller
{
    public function indexAction(): void
    {
        $notes = Note::find([
            'order' => 'updated_at DESC',
        ]);

        $this->view->setVar('title', 'Notes');
        $this->view->setVar('notes', $notes);
    }

    public function createAction(): void
    {
        $this->view->setVar('title', 'Create note');
        $this->view->setVar('note', new Note());
    }

    public function storeAction(): void
    {
        /** @var RequestInterface $request */
        $request = $this->request;

        $note = new Note();
        $note->title = (string)$request->getPost('title', 'string', '');
        $note->slug = (string)$request->getPost('slug', 'string', '');
        $note->content = (string)$request->getPost('content', 'string', '');

        try {
            $saved = $note->save();
        } catch (Throwable $e) {
            $saved = false;
            $this->view->setVar('errors', [$e->getMessage()]);
        }

        if (!$saved) {
            $this->view->setVar('title', 'Create note');
            $this->view->setVar('note', $note);
            $this->view->setVar('errors', $this->view->getVar('errors') ?? $note->getMessages());
            $this->view->pick('notes/create');
            return;
        }

        if ($note->id === null && $note->slug !== '') {
            $fresh = Note::findFirstBySlug($note->slug);
            if ($fresh) {
                $note = $fresh;
            }
        }

        $this->view->disable();
        if ($note->id !== null) {
            $this->response->redirect('/notes/' . (string)$note->id)->send();
            return;
        }

        $this->response->redirect('/notes')->send();
    }

    public function showAction(int $id): void
    {
        $note = Note::findFirstById($id);
        if (!$note) {
            $this->response->setStatusCode(404, 'Not Found')->send();
            $this->view->disable();
            return;
        }

        $this->view->setVar('title', $note->title);
        $this->view->setVar('note', $note);
    }

    public function editAction(int $id): void
    {
        $note = Note::findFirstById($id);
        if (!$note) {
            $this->response->setStatusCode(404, 'Not Found')->send();
            $this->view->disable();
            return;
        }

        $this->view->setVar('title', 'Edit note');
        $this->view->setVar('note', $note);
    }

    public function updateAction(int $id): void
    {
        /** @var RequestInterface $request */
        $request = $this->request;

        $note = Note::findFirstById($id);
        if (!$note) {
            $this->response->setStatusCode(404, 'Not Found')->send();
            $this->view->disable();
            return;
        }

        $note->title = (string)$request->getPost('title', 'string', '');
        $note->slug = (string)$request->getPost('slug', 'string', '');
        $note->content = (string)$request->getPost('content', 'string', '');

        try {
            $saved = $note->save();
        } catch (Throwable $e) {
            $saved = false;
            $this->view->setVar('errors', [$e->getMessage()]);
        }

        if (!$saved) {
            $this->view->setVar('title', 'Edit note');
            $this->view->setVar('note', $note);
            $this->view->setVar('errors', $this->view->getVar('errors') ?? $note->getMessages());
            $this->view->pick('notes/edit');
            return;
        }

        $this->view->disable();
        $this->response->redirect('/notes/' . (string)$note->id)->send();
    }

    public function deleteAction(int $id): void
    {
        $note = Note::findFirstById($id);
        if (!$note) {
            $this->response->setStatusCode(404, 'Not Found')->send();
            $this->view->disable();
            return;
        }

        $note->delete();
        $this->view->disable();
        $this->response->redirect('/notes')->send();
    }
}
