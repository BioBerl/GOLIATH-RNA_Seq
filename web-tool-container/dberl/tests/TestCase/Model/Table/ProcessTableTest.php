<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProcessTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProcessTable Test Case
 */
class ProcessTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProcessTable
     */
    public $Process;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.process'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Process') ? [] : ['className' => ProcessTable::class];
        $this->Process = TableRegistry::getTableLocator()->get('Process', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Process);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
