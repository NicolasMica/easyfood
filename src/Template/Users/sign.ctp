<?php $this->assign('title', 'Inscription & connexion'); ?>

<div class="container">
    <div class="row">
        <!-- Login Form -->
        <div class="col-xs-12 col-md-5 col-lg-4">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <?= $this->Form->create(null, ['url' => ['_name' => 'users:login']]) ?>
                        <div class="card-content">
                            <span class="card-title">Connexion</span>
                            <div class="input-field">
                                <?= $this->Form->control('email', ['id' => 'logEmail', 'label' => false, 'required' => true, 'aria-required' => true]) ?>
                                <label for="logEmail">Adresse e-mail</label>
                            </div>
                            <div class="input-field">
                                <?= $this->Form->control('password', ['id' => 'logPass', 'label' => false, 'required' => true, 'aria-required' => true]) ?>
                                <label for="logPass">Mot de passe</label>
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
                <div class="col-xs-12">
                    <div class="card-panel">
                        <?= $this->Html->link("Mot de passe oublié ?", ['_name' => 'users:forgot'], ['class' => 'blue-text waves-effect']) ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Register Form -->
        <div class="col-xs-12 col-md-7 col-lg-8">
            <div class="card">
                <?= $this->Form->create($user, ['url' => ['_name' => 'users:register']]) ?>
                <?php $this->Form->unlockField('city_id'); $this->Form->unlockField('gender'); ?>
                    <div class="card-content no-row-marg">
                        <span class="card-title">Inscription</span>
                        <div class="row">
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->input('lastname', ['id' => 'reg1', 'required' => true, 'aria-required' => true, 'label' => false]) ?>
                                <label for="reg1">Nom</label>
                            </div>
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->input('firstname', ['id' => 'reg2', 'required' => true, 'aria-required' => true, 'label' => false]) ?>
                                <label for="reg2">Prénom</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->select('gender', ['' => 'Civilité', 'Homme' => 'Homme', 'Femme' => 'Femme'], ['label' => false, 'disabled' => [''], 'default' => [''], 'required' => true, 'aria-required' => true]) ?>
                                <?php if ($this->Form->isFieldError('gender')) echo $this->Form->error('gender'); ?>
                            </div>
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->input('email', ['id' => 'reg4', 'required' => true, 'aria-required' => true, 'label' => false]) ?>
                                <label for="reg4">Adresse E-mail</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->input('password', ['id' => 'reg5', 'required' => true, 'aria-required' => true, 'label' => false]) ?>
                                <label for="reg5">Mot de passe</label>
                            </div>
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->input('confirm', ['id' => 'reg6', 'required' => true, 'aria-required' => true, 'label' => false, 'type' => 'password']) ?>
                                <label for="reg6">Confirmation</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->input('address', ['id' => 'reg7', 'required' => true, 'aria-required' => true, 'label' => false]) ?>
                                <label for="reg7">Adresse</label>
                            </div>
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->select('city_id',  $cities, ['label' => false, 'disabled' => [''], 'default' => [''], 'required' => true, 'aria-required' => true]) ?>
                                <?php if ($this->Form->isFieldError('city_id')) echo $this->Form->error('city_id'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 input-field">
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
