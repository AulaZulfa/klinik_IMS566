<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DoctorsFixture
 */
class DoctorsFixture extends TestFixture
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
                'phone' => 'Lorem ipsum dolor ',
                'email' => 'Lorem ipsum dolor sit a',
                'status' => 1,
                'created' => '2026-01-12 16:02:04',
                'modified' => '2026-01-12 16:02:04',
            ],
        ];
        parent::init();
    }
}
