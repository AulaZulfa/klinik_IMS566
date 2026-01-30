<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\SearchTrait;

/**
 * Patients Model
 *
 * @method \App\Model\Entity\Patient newEmptyEntity()
 * @method \App\Model\Entity\Patient newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Patient> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Patient get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Patient findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Patient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Patient> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Patient|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Patient saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Patient>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Patient>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Patient>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Patient> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Patient>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Patient>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Patient>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Patient> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PatientsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
   
    use SearchTrait;
   
    public function initialize(array $config): void
{
    parent::initialize($config);

    $this->setTable('patients');
    $this->setPrimaryKey('id');

    $this->addBehavior('Timestamp');
    
    // Pastikan behavior ini ada
    $this->addBehavior('Search.Search');

    $this->belongsTo('Users', [
        'foreignKey' => 'user_id',
    ]);

    // PADAM kod lama, GANTI dengan ini sahaja:
    $this->searchManager()
        ->add('name', 'Search.Like', [
            'before' => true,
            'after' => true,
            'fields' => ['name'] // Gunakan 'fields' (plural)
        ])
        ->add('email', 'Search.Like', [
            'before' => true,
            'after' => true,
            'fields' => ['email']
        ])
        ->add('ic', 'Search.Like', [
            'before' => true,
            'after' => true,
            'fields' => ['ic']
        ])
        ->add('status', 'Search.Callback', [
            'callback' => function ($query, $args, $filter) {
                if (!empty($args['status'])) {
                    return $query->where(['Patients.status IN' => $args['status']]);
                }
                return true;
            }
        ]);
}

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('email')
            ->maxLength('email', 255)
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

            $validator
            ->integer('ic')
            ->requirePresence('ic', 'create')
            ->notEmptyString('ic');

        $validator
            ->integer('phone')
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone');

        $validator
            ->scalar('street_1')
            ->maxLength('street_1', 255)
            ->requirePresence('street_1', 'create')
            ->notEmptyString('street_1');

        $validator
            ->scalar('street_2')
            ->maxLength('street_2', 255)
            ->requirePresence('street_2', 'create')
            ->notEmptyString('street_2');

        $validator
            ->integer('postcode')
            ->requirePresence('postcode', 'create')
            ->notEmptyString('postcode');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->requirePresence('city', 'create')
            ->notEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 255)
            ->requirePresence('state', 'create')
            ->notEmptyString('state');

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
{
    // $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']); 
    // KOMENKAN BARIS ATAS NI ^

    return $rules;
}
}
