<?php
namespace App\Model\Table;

use App\Model\Entity\Review;
use ArrayObject;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Reviews Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Restaurants
 * @property \Cake\ORM\Association\BelongsTo $Orders
 * @property \Cake\ORM\Association\HasMany $RejectedReviews
 *
 * @method \App\Model\Entity\Review get($primaryKey, $options = [])
 * @method \App\Model\Entity\Review newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Review[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Review|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Review patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Review[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Review findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReviewsTable extends Table
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

        $this->setTable('reviews');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Restaurants', [
            'foreignKey' => 'restaurant_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('RejectedReviews', [
            'foreignKey' => 'review_id'
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
            ->integer('quality')
            ->requirePresence('quality', 'create')
            ->notEmpty('quality')
            ->add('quality', 'range', [
                'rule' => ['range', 1, 5],
                'message' => __("La note doit être comprise entre 1 et 5")
            ]);

        $validator
            ->integer('recipe')
            ->requirePresence('recipe', 'create')
            ->notEmpty('recipe')
            ->add('recipe', 'range', [
                'rule' => ['range', 1, 5],
                'message' => __("La note doit être comprise entre 1 et 5")
            ]);

        $validator
            ->integer('design')
            ->requirePresence('design', 'create')
            ->notEmpty('design')
            ->add('design', 'range', [
                'rule' => ['range', 1, 5],
                'message' => __("La note doit être comprise entre 1 et 5")
            ]);

        $validator
            ->integer('price')
            ->requirePresence('price', 'create')
            ->notEmpty('price')
            ->add('price', 'range', [
                'rule' => ['range', 1, 5],
                'message' => __("La note doit être comprise entre 1 et 5")
            ]);

        $validator
            ->integer('delivery')
            ->requirePresence('delivery', 'create')
            ->notEmpty('delivery')
            ->add('delivery', 'range', [
                'rule' => ['range', 1, 5],
                'message' => __("La note doit être comprise entre 1 et 5")
            ]);

        $validator
            ->integer('employee')
            ->requirePresence('employee', 'create')
            ->notEmpty('employee')
            ->add('employee', 'range', [
                'rule' => ['range', 1, 5],
                'message' => __("La note doit être comprise entre 1 et 5")
            ]);

        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content', __("Ce champ est obligatoire"))
            ->minLength('content', 10, __("Ce champ doit contenir au minimum 10 caractères"));

        $validator
            ->boolean('active')
            ->notEmpty('active', __("Ce champ est obligatoire"));

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'));

        return $rules;
    }

    public function findQueue (Query $query, array $options)
    {
        $subquery = $this->query()
            ->select('RejectedReviews.review_id')
            ->from('rejected_reviews RejectedReviews')
            ->where([
                'RejectedReviews.review_id = Reviews.id',
                'RejectedReviews.created > Reviews.modified'
            ])
            ->orderDesc('RejectedReviews.created');

        return $query->from('reviews Reviews')
            ->where([
                'Reviews.active' => false,
                'Reviews.id NOT IN' => $subquery
            ]);
    }

    public function afterSave (Event $event, Review $entity, ArrayObject $options) {
        Cache::delete('pendding_reviews_count');
    }

    public function afterDelete (Event $event, Review $entity, ArrayObject $options) {
        Cache::delete('pendding_reviews_count');
    }
}
