<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GeneralsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GeneralsTable Test Case
 */
class GeneralsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GeneralsTable
     */
    protected $Generals;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Generals',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Generals') ? [] : ['className' => GeneralsTable::class];
        $this->Generals = $this->getTableLocator()->get('Generals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Generals);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\GeneralsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
