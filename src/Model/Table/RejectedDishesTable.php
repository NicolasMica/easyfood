<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RejectedDishes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Dishes
 *
 * @method \App\Model\Entity\RejectedDish get($primaryKey, $options = [])
 * @method \App\Model\Entity\RejectedDish newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RejectedDish[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RejectedDish|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RejectedDish patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RejectedDish[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RejectedDish findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RejectedDishesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('rejected_dishes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Dishes', [
            'foreignKey' => 'dish_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('content', 'create')
            ->minLength('content', 10, __("La raison de l'invalidation doit contenir au minimum 10 caractères."))
            ->notEmpty('content', __("Ce champ est requis."));

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['dish_id'], 'Dishes'));

        return $rules;
    }
}
