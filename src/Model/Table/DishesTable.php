<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Dishes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Restaurants
 * @property \Cake\ORM\Association\BelongsTo $DishTypes
 *
 * @method \App\Model\Entity\Dish get($primaryKey, $options = [])
 * @method \App\Model\Entity\Dish newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Dish[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Dish|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Dish patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Dish[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Dish findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DishesTable extends Table
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

        $this->setTable('dishes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Restaurants', [
            'foreignKey' => 'restaurant_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('DishTypes', [
            'foreignKey' => 'dish_type_id'
        ]);

        $this->addBehavior('Uploadable', [
            'saveDest' => WWW_ROOT . 'storage' . DS . 'dishes' . DS,
            "ext" => ['jpg', 'jpeg', 'png']
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
            ->requirePresence('description', 'create')
            ->allowEmpty('description')
            ->minLength('description', 10, __("Ce champ doit contenir au minimum 10 caractères"));

        $validator
            ->requirePresence('supplier_price', 'create')
            ->notEmpty('supplier_price', __("Ce champ est obligatoire"))
            ->add('supplier_price', 'validPrice', [
                'rule' => [$this, 'validatePrice'],
                'message' => __("Ce champ doit contenir un prix supérieur à 0")
            ]);

        $validator
            ->requirePresence('selling_price', 'create')
            ->notEmpty('selling_price', __("Ce champ est obligatoire"))
            ->add('selling_price', 'validPrice', [
                'rule' => [$this, 'validatePrice'],
                'message' => __("Ce champ doit contenir un prix supérieur à 0")
            ]);

        $validator
            ->requirePresence('image', 'create', __("Ce champ est obligatoire à la création"))
            ->add('image', 'file', [
                'rule' => [$this, 'validatePictureFormat'],
                'message' => __("L'image doit être au format JPEG ou PNG")
            ])
            ->add('image', 'size', [
                'rule' => [$this, 'validatePictureSize'],
                'message' => __("La taille maximal de l'image est de 600x600 pixels")
            ])
            ->add('image', 'square', [
                'rule' => [$this, 'validatePictureSquare'],
                'message' => __("L'image doit être carrée (ex: 300x300)")
            ]);

        $validator
            ->boolean('active')
            ->notEmpty('active',  __("Ce champ est obligatoire"));

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

    public function findPublished (Query $query, array $options) {
        return $query->where(['active' => true]);
    }

    public function validatePrice ($value, array $context) {
        return (bool) preg_match('#^([1-9][0-9]*|0)(\.[0-9]{0,2})?$#', $value);
    }

    public function validatePictureSize ($value, array $context) {
        $size = getimagesize($value['tmp_name']);

        return $size[0] <= 600 && $size[1] <= 600;
    }

    public function validatePictureSquare ($value, array $context) {
        $size = getimagesize($value['tmp_name']);

        return $size[0] === $size[1];
    }

    public function validatePictureFormat ($value, array $context) {
        return in_array($value['type'], ['image/jpeg', 'image/jpg', 'image/png']);
    }
}
