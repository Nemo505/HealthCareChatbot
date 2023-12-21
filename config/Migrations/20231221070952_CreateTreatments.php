<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateTreatments extends AbstractMigration
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
        $treatmentTable = $this->table('treatments');
        $treatmentTable->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $treatmentTable->addColumn('description', 'string', [
            'default' => null,
            'null' => false,
        ]);

        $treatmentTable->addColumn('symptom_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $treatmentTable->addForeignKey('symptom_id', 'symptoms', 'id', [
            'delete' => 'SET_NULL', 
            'update' => 'CASCADE', 
        ]);

        $treatmentTable->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $treatmentTable->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $treatmentTable->create();
    }
}
