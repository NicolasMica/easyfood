<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use ArrayObject;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Cities
 * @property \Cake\ORM\Association\BelongsTo $Roles
 * @property \Cake\ORM\Association\HasMany $Tokens
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id'
        ]);
        $this->hasMany('Tokens', [
            'foreignKey' => 'user_id'
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
            ->requirePresence('lastname', 'create')
            ->notEmpty('lastname', __("Ce champ est obligatoire"))
            ->minLength('lastname', 3, __("Ce champ doit contenir au minimum 3 caractères"));

        $validator
            ->requirePresence('firstname', 'create')
            ->notEmpty('firstname', __("Ce champ est obligatoire"))
            ->minLength('firstname', 3, __("Ce champ doit contenir au minimum 3 caractères"));

        $validator
            ->requirePresence('gender', 'create', __("Ce champ est obligatoire"))
            ->notBlank('gender', __("Veuillez choisir dans la liste"));

        $validator
            ->email('email', false, __("Ce champ doit contenir une adresse e-mail valide"))
            ->requirePresence('email', 'create')
            ->notEmpty('email', __("Ce champ est obligatoire"));

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', __("Ce champ est obligatoire"))
            ->minLength('password', 6, __("Ce champ doit contenir au minimum 6 caractères"));

        $validator
            ->requirePresence('confirm', 'create')
            ->notEmpty('confirm',  __("Ce champ est obligatoire"))
            ->sameAs('confirm', 'password', __("Ce champ doit être identique au champ mot de passe"));


        $validator
            ->boolean('newsletter')
            ->requirePresence('newsletter', 'create')
            ->notEmpty('newsletter');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address', __("Ce champ est obligatoire"));

        $validator
            ->requirePresence('city_id', 'create', __("Ce champ est obligatoire"))
            ->notBlank('city_id', __("Veuillez choisir dans la liste"));

        return $validator;
    }

    /**
     * Password validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationPassword(Validator $validator) {
        $validator
            ->notEmpty('old', __("Ce champ est obligatoire"))
            ->add('old','custom', [
                'rule'=> function ($value, $context) {
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        if ((new DefaultPasswordHasher)->check($value, $user->password)) {
                            return true;
                        }
                    }
                    return false;
                },
                'message' => __("Le mot de passe est incorrect")
            ]);

        $validator
            ->notEmpty('password', __("Ce champ est obligatoire"))
            ->minLength('password', 6, __("Ce champ doit contenir au minimum 6 caractères"))
            ->add('password','custom', [
                'rule'=> function ($value, $context) {
                    return ($context['data']['old'] != $value);
                },
                'message' => __("Le nouveau mot de passe doit être différent de l'ancien")
            ]);

        $validator
            ->notEmpty('confirm',  __("Ce champ est obligatoire"))
            ->sameAs('confirm', 'password', __("Ce champ doit être identique au nouveau mot de passe"))
            ->add('confirm','custom', [
                'rule'=> function ($value, $context) {
                    return ($context['data']['old'] != $value);
                },
                'message' => __("Le nouveau mot de passe doit être différent de l'ancien")
            ]);

        return $validator;
    }

    /**
     * @param Validator $validator
     * @return Validator
     */
    public function validationResetPassword(Validator $validator) {
        $validator
            ->notEmpty('password', __("Ce champ est obligatoire"))
            ->minLength('password', 6, __("Ce champ doit contenir au minimum 6 caractères"));

        $validator
            ->notEmpty('confirm',  __("Ce champ est obligatoire"))
            ->sameAs('confirm', 'password', __("Ce champ doit être identique au nouveau mot de passe"));

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
        $rules->add($rules->isUnique(['email'], __("Cette adresse e-mail est déjà utilisée")));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }

    public function findAuth (Query $query, array $options) {
        return $query->select(['id', 'email', 'password', 'role_id'])->contain([
            'Roles' => function (Query $query) {
                return $query->select(['id', 'name', 'level']);
            }
        ]);
    }

    public function afterSave (Event $event, User $entity, ArrayObject $options) {
        Cache::delete($entity->id . '-users');
    }

    public function afterDelete (Event $event, User $entity, ArrayObject $options) {
        Cache::delete($entity->id . '-users');
    }
}
