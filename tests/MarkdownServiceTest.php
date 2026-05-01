<?php

declare(strict_types=1);

namespace NoteForge\Tests;

use NoteForge\Services\MarkdownService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MarkdownService::class)]
final class MarkdownServiceTest extends TestCase
{
    public function testRendersMarkdownToHtml(): void
    {
        $service = new MarkdownService();

        $html = $service->render("# Title\n\nHello");

        self::assertIsString($html);
        self::assertNotSame('', trim($html));
        self::assertStringContainsString('Title', $html);
    }
}
