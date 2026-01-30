<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AppointmentsFixture
 */
class AppointmentsFixture extends TestFixture
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
                'patient_id' => 1,
                'doctor_id' => 1,
                'date' => '2026-01-12',
                'start_time' => '16:06:40',
                'end_time' => '16:06:40',
                'purpose' => 'Lorem ipsum dolor sit amet',
                'status' => 1,
                'created' => '2026-01-12 16:06:40',
                'modified' => '2026-01-12 16:06:40',
            ],
        ];
        parent::init();
    }
}
