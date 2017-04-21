<?php $this->assign('title', 'Inscription & connexion'); ?>

<div class="container">
    <div class="row">
        <!-- Login Form -->
        <div class="col s12 m6 l4">
            <div class="card">
                <?= $this->Form->create(null, ['url' => ['_name' => 'users:login']]) ?>
                    <div class="div card-content">
                        <span class="card-title">Connexion</span>
                        <div class="input-field">
                            <?= $this->Form->control('email', ['id' => 'logEmail', 'label' => false, 'required' => true, 'aria-required' => true]) ?>
                            <label for="logEmail" data-error="Une adresse e-mail valide est requise">Adresse E-mail</label>
                        </div>
                        <div class="input-field">
                            <?= $this->Form->control('password', ['id' => 'logPass', 'label' => false, 'required' => true, 'aria-required' => true]) ?>
                            <label for="logPass" data-error="Veuillez indiquer votre mot de passe">Mot de passe</label>
                        </div>
                        <div class="input-field">
                            <?= $this->Form->checkbox('remember', ['id' => 'logRemember', 'class' => false, 'label' => false]) ?>
                            <label for="logRemember">Garder ma session active</label>
                        </div>
                    </div>
                    <div class="card-action right-align">
                        <?= $this->Form->button('Connexion', ['class' => 'btn green waves-effect']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
        <!-- Register Form -->
        <div class="col s12 m6 l8">
            <div class="card">
                <?= $this->Form->create(null, ['url' => ['_name' => 'users:register']]) ?>
                    <div class="card-content">
                        <span class="card-title">Inscription</span>
                        <div class="row">
                            <div class="col s12 m6 input-field">
                                <?= $this->Form->input('lastname', ['id' => 'reg1', 'required' => true, 'aria-required' => true, 'label' => false]) ?>
                                <label for="reg1">Nom</label>
                            </div>
                            <div class="col s12 m6 input-field">
                                <?= $this->Form->input('firstname', ['id' => 'reg2', 'required' => true, 'aria-required' => true, 'label' => false]) ?>
                                <label for="reg2">Prénom</label>
                            </div>
                            <div class="col s12 m6 input-field">
                                <?= $this->Form->select('gender', ['' => 'Civilité', 'Homme' => 'Homme', 'Femme' => 'Femme'], ['label' => false, 'disabled' => [''], 'default' => ['']]) ?>
                            </div>
                            <div class="col s12 m6 input-field">
                                <?= $this->Form->input('email', ['id' => 'reg4', 'required' => true, 'aria-required' => true, 'label' => false]) ?>
                                <label for="reg4" data-error="Veuillez indiquer une adresse e-mail valide.">Adresse E-mail</label>
                            </div>
                            <div class="col s12 m6 input-field">
                                <?= $this->Form->input('password', ['id' => 'reg5', 'required' => true, 'aria-required' => true, 'label' => false]) ?>
                                <label for="reg5">Mot de passe</label>
                            </div>
                            <div class="col s12 m6 input-field">
                                <?= $this->Form->input('confirm', ['id' => 'reg6', 'required' => true, 'aria-required' => true, 'label' => false, 'type' => 'password']) ?>
                                <label for="reg6">Confirmation</label>
                            </div>
                            <div class="col s12 m6 input-field">
                                <?= $this->Form->input('address', ['id' => 'reg7', 'required' => true, 'aria-required' => true, 'label' => false]) ?>
                                <label for="reg7">Adresse</label>
                            </div>
                            <div class="col s12 m6 input-field">
                                <?= $this->Form->select('city',  $cities, ['label' => false, 'disabled' => [''], 'default' => ['']]) ?>
                            </div>
                            <div class="col s12 input-field">
                                <?= $this->Form->checkbox('newsletter', ['id' => 'reg9', 'class' => false, 'label' => false]) ?>
                                <label for="reg9">Recevoir les newsletters</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-action right-align">
                        <?= $this->Form->button('Inscription', ['class' => 'btn green waves-effect']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
