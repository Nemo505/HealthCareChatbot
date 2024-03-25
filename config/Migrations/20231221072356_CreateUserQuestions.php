<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUserQuestions extends AbstractMigration
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
        $questionTable = $this->table('user_questions');
        $questionTable->addColumn('questions', 'string', [
            'default' => null,
            'null' => false,
        ]);

        define('categories', ['general', 'symptom', 'treatment']);

        $questionTable->addColumn('category', 'enum', [
                'values' => categories,
                'default' => categories[1], 
                'null' => false,
        ]);

        $questionTable->addColumn('answer_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);

        $questionTable->addColumn('user_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);

        $questionTable->addForeignKey('user_id', 'users', 'id', [
            'delete' => 'SET_NULL', 
            'update' => 'CASCADE', 
        ]);

        define('feedbacks', ['helpful', 'unhelpful']);
        $questionTable->addColumn('feedback', 'enum', [
            'values' => feedbacks,
            'default' => null,
            'null' => true,
        ]);

        $questionTable->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $questionTable->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $questionTable->create();
    }
}
