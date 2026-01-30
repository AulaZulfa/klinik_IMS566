<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\DoctorsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\DoctorsController Test Case
 *
 * @uses \App\Controller\DoctorsController
 */
class DoctorsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Doctors',
        'app.Slots',
    ];

    /**
     * Test beforeFilter method
     *
     * @return void
     * @uses \App\Controller\DoctorsController::beforeFilter()
     */
    public function testBeforeFilter(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test json method
     *
     * @return void
     * @uses \App\Controller\DoctorsController::json()
     */
    public function testJson(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test csv method
     *
     * @return void
     * @uses \App\Controller\DoctorsController::csv()
     */
    public function testCsv(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test pdfList method
     *
     * @return void
     * @uses \App\Controller\DoctorsController::pdfList()
     */
    public function testPdfList(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\DoctorsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\DoctorsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\DoctorsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\DoctorsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\DoctorsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test archived method
     *
     * @return void
     * @uses \App\Controller\DoctorsController::archived()
     */
    public function testArchived(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
