<?php

declare(strict_types=1);

namespace NoteForge\Services;

use MarkForge\MarkForge;

final class MarkdownService
{
    private MarkForge $parser;

    public function __construct(?MarkForge $parser = null)
    {
        $this->parser = $parser ?? new MarkForge();
    }

    public function render(string $markdown): string
    {
        return $this->parser->parse($markdown);
    }
}
