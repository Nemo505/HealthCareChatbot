<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserQuestionsFixture
 */
class UserQuestionsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'questions' => 'Lorem ipsum dolor sit amet',
                'category' => 'Lorem ipsum dolor sit amet',
                'answer_id' => 1,
                'user_id' => 1,
                'feedback' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-03-22 09:53:02',
                'modified' => '2024-03-22 09:53:02',
            ],
        ];
        parent::init();
    }
}
