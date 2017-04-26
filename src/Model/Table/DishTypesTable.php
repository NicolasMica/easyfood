<?php
namespace App\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DishTypes Model
 *
 * @property \Cake\ORM\Association\HasMany $Dishes
 * @property \Cake\ORM\Association\BelongsToMany $Restaurants
 *
 * @method \App\Model\Entity\DishType get($primaryKey, $options = [])
 * @method \App\Model\Entity\DishType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DishType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DishType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DishType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DishType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DishType findOrCreate($search, callable $callback = null, $options = [])
 */
class DishTypesTable extends Table
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

        $this->setTable('dish_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Dishes', [
            'foreignKey' => 'dish_type_id'
        ]);
        $this->belongsToMany('Restaurants', [
            'foreignKey' => 'dish_type_id',
            'targetForeignKey' => 'restaurant_id',
            'joinTable' => 'dish_types_restaurants'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }

    /**
     * @param Event $event
     * @param Query $query
     */
    public function beforeFind(Event $event, Query $query)
    {
        $query->orderAsc('DishTypes.name');
    }
}
