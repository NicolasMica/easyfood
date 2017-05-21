<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DishesOrders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Dishes
 * @property \Cake\ORM\Association\BelongsTo $Orders
 *
 * @method \App\Model\Entity\DishesOrder get($primaryKey, $options = [])
 * @method \App\Model\Entity\DishesOrder newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DishesOrder[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DishesOrder|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DishesOrder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DishesOrder[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DishesOrder findOrCreate($search, callable $callback = null, $options = [])
 */
class DishesOrdersTable extends Table
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

        $this->setTable('dishes_orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Dishes', [
            'foreignKey' => 'dish_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
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
            ->integer('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'));

        return $rules;
    }
}
