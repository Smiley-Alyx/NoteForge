<?php

declare(strict_types=1);

namespace NoteForge\Models;

use Phalcon\Mvc\Model;
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\PresenceOf;

final class Note extends Model
{
    public $id = null;

    public $title = '';

    public $slug = '';

    public $content = '';

    public $created_at = null;

    public $updated_at = null;

    public function initialize(): void
    {
        $this->setSource('notes');

        $this->skipAttributesOnCreate(['id']);
    }

    public function beforeValidationOnCreate(): void
    {
        $now = date('Y-m-d H:i:sP');

        $this->created_at = $now;
        $this->updated_at = $now;
    }

    public function beforeValidationOnUpdate(): void
    {
        $this->updated_at = date('Y-m-d H:i:sP');
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
            'slug',
            new PresenceOf([
                'message' => 'Slug is required',
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
