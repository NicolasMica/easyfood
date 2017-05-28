<?php
namespace App\Model\Table;

use App\Model\Entity\Restaurant;
use ArrayObject;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Restaurants Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Cities
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $Dishes
 * @property \Cake\ORM\Association\HasMany $Reviews
 * @property \Cake\ORM\Association\BelongsToMany $DishTypes
 *
 * @method \App\Model\Entity\Restaurant get($primaryKey, $options = [])
 * @method \App\Model\Entity\Restaurant newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Restaurant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Restaurant|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Restaurant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Restaurant[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Restaurant findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RestaurantsTable extends Table
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

        $this->setTable('restaurants');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Dishes', [
            'foreignKey' => 'restaurant_id'
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'restaurant_id'
        ]);
        $this->belongsToMany('DishTypes', [
            'foreignKey' => 'restaurant_id',
            'targetForeignKey' => 'dish_type_id',
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
            ->notEmpty('name', __("Ce champ est obligatoire"))
            ->minLength('name', 3, __("Ce champ doit contenir au minimum 3 caractères"));

        $validator
            ->allowEmpty('description')
            ->minLength('description', 10, __("Ce champ doit contenir au minimum 10 caractères"));

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address', __("Ce champ est obligatoire"));

        $validator
            ->requirePresence('city_id', 'create', __("Ce champ est obligatoire"))
            ->notBlank('city_id', __("Veuillez choisir dans la liste"));

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
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     * @param Event $event
     * @param Query $query
     */
    public function beforeFind(Event $event, Query $query)
    {
        $query->orderAsc('Restaurants.name');
    }

    public function afterSave (Event $event, Restaurant $entity, ArrayObject $options) {
        Cache::deleteMany(['my_restaurants', 'restaurants', 'dish_types']);
    }

    public function afterDelete (Event $event, Restaurant $entity, ArrayObject $options) {
        Cache::deleteMany(['dishes', 'restaurants', 'my_restaurants']);
    }
}
