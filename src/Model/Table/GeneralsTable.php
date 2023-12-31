<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Generals Model
 *
 * @method \App\Model\Entity\General newEmptyEntity()
 * @method \App\Model\Entity\General newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\General[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\General get($primaryKey, $options = [])
 * @method \App\Model\Entity\General findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\General patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\General[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\General|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\General saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\General[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\General[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\General[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\General[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GeneralsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('generals');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('content')
            ->maxLength('content', 255)
            ->requirePresence('content', 'create')
            ->notEmptyString('content');

        return $validator;
    }
}
