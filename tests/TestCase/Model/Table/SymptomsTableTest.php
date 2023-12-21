<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SymptomsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SymptomsTable Test Case
 */
class SymptomsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SymptomsTable
     */
    protected $Symptoms;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Symptoms',
        'app.Treatments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Symptoms') ? [] : ['className' => SymptomsTable::class];
        $this->Symptoms = $this->getTableLocator()->get('Symptoms', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Symptoms);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SymptomsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
