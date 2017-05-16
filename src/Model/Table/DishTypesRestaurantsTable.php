<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DishTypesRestaurants Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Restaurants
 * @property \Cake\ORM\Association\BelongsTo $DishTypes
 *
 * @method \App\Model\Entity\DishTypesRestaurant get($primaryKey, $options = [])
 * @method \App\Model\Entity\DishTypesRestaurant newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DishTypesRestaurant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DishTypesRestaurant|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DishTypesRestaurant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DishTypesRestaurant[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DishTypesRestaurant findOrCreate($search, callable $callback = null, $options = [])
 */
class DishTypesRestaurantsTable extends Table
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

        $this->setTable('dish_types_restaurants');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Restaurants', [
            'foreignKey' => 'restaurant_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('DishTypes', [
            'foreignKey' => 'dish_type_id',
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
        $rules->add($rules->existsIn(['restaurant_id'], 'Restaurants'));
        $rules->add($rules->existsIn(['dish_type_id'], 'DishTypes'));

        return $rules;
    }
}
