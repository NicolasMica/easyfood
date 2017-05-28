<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RejectedReviews Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Reviews
 *
 * @method \App\Model\Entity\RejectedReview get($primaryKey, $options = [])
 * @method \App\Model\Entity\RejectedReview newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RejectedReview[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RejectedReview|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RejectedReview patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RejectedReview[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RejectedReview findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RejectedReviewsTable extends Table
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

        $this->setTable('rejected_reviews');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Reviews', [
            'foreignKey' => 'review_id',
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
            ->notEmpty('content');

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
        $rules->add($rules->existsIn(['review_id'], 'Reviews'));

        return $rules;
    }
}
