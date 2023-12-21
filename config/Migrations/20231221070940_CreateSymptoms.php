<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateSymptoms extends AbstractMigration
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
        $symptomTable = $this->table('symptoms');
        $symptomTable->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $symptomTable->addColumn('description', 'string', [
            'default' => null,
            'null' => false,
        ]);
        
        $symptomTable->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $symptomTable->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $symptomTable->create();
    }
}
