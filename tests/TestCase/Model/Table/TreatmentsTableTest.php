<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TreatmentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TreatmentsTable Test Case
 */
class TreatmentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TreatmentsTable
     */
    protected $Treatments;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Treatments',
        'app.Symptoms',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Treatments') ? [] : ['className' => TreatmentsTable::class];
        $this->Treatments = $this->getTableLocator()->get('Treatments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Treatments);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TreatmentsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\TreatmentsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
