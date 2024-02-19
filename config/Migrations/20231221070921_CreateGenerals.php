<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateGenerals extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $generalTable = $this->table('generals');
        $generalTable->addColumn('title', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $generalTable->addColumn('content', 'string', [
            'default' => null,
            'null' => false,
        ]);

        $generalTable->addColumn('keyword', 'string', [
            'default' => null,
            'null' => false,
        ]);

        $generalTable->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $generalTable->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $generalTable->create();
    }
}
