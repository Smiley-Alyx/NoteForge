<?php

declare(strict_types=1);

namespace NoteForge\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

final class Note extends Model
{
    public ?int $id = null;

    public string $title = '';

    public string $slug = '';

    public string $content = '';

    public ?string $created_at = null;

    public ?string $updated_at = null;

    public function initialize(): void
    {
        $this->setSource('notes');

        $this->addBehavior(
            new Timestampable([
                'beforeCreate' => [
                    'field' => 'created_at',
                    'format' => 'Y-m-d H:i:sP',
                ],
            ])
        );

        $this->addBehavior(
            new Timestampable([
                'beforeSave' => [
                    'field' => 'updated_at',
                    'format' => 'Y-m-d H:i:sP',
                ],
            ])
        );
    }

    public function validation(): bool
    {
        $validation = new Validation();

        $validation->add(
            'title',
            new PresenceOf([
                'message' => 'Title is required',
            ])
        );

        $validation->add(
            'content',
            new PresenceOf([
                'message' => 'Content is required',
            ])
        );

        return $this->validate($validation);
    }
}
