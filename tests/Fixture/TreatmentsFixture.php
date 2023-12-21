<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TreatmentsFixture
 */
class TreatmentsFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'symptom_id' => 1,
                'created' => '2023-12-21 08:47:09',
                'modified' => '2023-12-21 08:47:09',
            ],
        ];
        parent::init();
    }
}
