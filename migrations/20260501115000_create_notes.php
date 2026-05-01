<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateNotes extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('notes', [
            'id' => false,
            'primary_key' => ['id'],
        ]);

        $table
            ->addColumn('id', 'biginteger', ['identity' => true])
            ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('slug', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('content', 'text', ['null' => false])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => false])
            ->addIndex(['slug'], ['unique' => true, 'name' => 'notes_slug_unique'])
            ->addIndex(['updated_at'], ['name' => 'notes_updated_at_idx'])
            ->create();
    }
}
