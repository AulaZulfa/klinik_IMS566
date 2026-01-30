<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PatientsFixture
 */
class PatientsFixture extends TestFixture
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
                'ic' => 1,
                'phone' => 1,
                'street_1' => 'Lorem ipsum dolor sit amet',
                'street_2' => 'Lorem ipsum dolor sit amet',
                'postcode' => 1,
                'city' => 'Lorem ipsum dolor sit amet',
                'state' => 'Lorem ipsum dolor sit amet',
                'status' => 1,
                'created' => '2026-01-05 16:31:07',
                'modified' => '2026-01-05 16:31:07',
            ],
        ];
        parent::init();
    }
}
