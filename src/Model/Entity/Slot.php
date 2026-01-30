<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Slot Entity
 *
 * @property int $id
 * @property int $doctor_id
 * @property \Cake\I18n\Date $date
 * @property \Cake\I18n\Time $time
 * @property int|null $status
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Doctor $doctor
 */
class Slot extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'doctor_id' => true,
        'date' => true,
        'time' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'doctor' => true,
    ];
}
