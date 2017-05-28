<?php $this->assign('title', "Préférences"); ?>

<?php $this->Html->scriptStart(['block' => true]); ?>
    $('.modal').modal();
<?php $this->Html->scriptEnd(); ?>

<div class="container">
    <!-- Profile -->
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <?= $this->Form->create($user) ?>
                    <div class="card-content">
                        <span class="card-title">Informations personnelles</span>
                        <div class="row">
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->input('lastname', ['required' => true, 'aria-required' => true, 'label' => "Nom"]) ?>
                            </div>
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->input('firstname', ['required' => true, 'aria-required' => true, 'label' => "Prénom"]) ?>
                            </div>
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->select('gender', ['Homme' => 'Homme', 'Femme' => 'Femme'], ['label' => false, 'disabled' => [''], 'default' => [''], 'required' => true, 'aria-required' => true]) ?>
                                <label>Civilité</label>
                                <?php if ($this->Form->isFieldError('gender')) echo $this->Form->error('gender'); ?>
                            </div>
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->input('email', ['required' => true, 'aria-required' => true, 'label' => "Adresse E-mail"]) ?>
                            </div>
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->input('address', ['required' => true, 'aria-required' => true, 'label' => 'Adresse']) ?>
                            </div>
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->select('city_id',  $cities, ['label' => false, 'required' => true, 'aria-required' => true]) ?>
                                <label>Ville</label>
                                <?php if ($this->Form->isFieldError('city_id')) echo $this->Form->error('city_id'); ?>
                            </div>
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->input('role.name', ['label' => 'Rôle du compte', 'disabled' => true, 'readonly' => true]) ?>
                            </div>
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->checkbox('newsletter', ['id' => 'prefNews', 'class' => false, 'label' => false]) ?>
                                <label for="prefNews">Recevoir les newsletters</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-action clearfix">
                        <a href="#deleteConfirm" class="btn red modal-trigger waves-effect waves-light"><i class="material-icons left">delete</i> Supprimer mon compte</a>
                        <?= $this->Form->button("<i class='material-icons left'>check</i> Sauvegarder", ['class' => 'btn green right waves-effect waves-light']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
    <!-- Password -->
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <?= $this->Form->create($pass, ['url' => ['_name' => 'users:password']]) ?>
                    <div class="card-content">
                        <span class="card-title">Modifier mon mot de passe</span>
                        <div class="row">
                            <div class="col-xs-12 col-md-4 input-field">
                                <?= $this->Form->input('old', ['type' => 'password', 'required' => true, 'aria-required' => true, 'label' => "Ancien mot de passe"]) ?>
                            </div>
                            <div class="col-xs-12 col-md-4 input-field">
                                <?= $this->Form->input('password', ['type' => 'password', 'required' => true, 'aria-required' => true, 'label' => "Nouveau mot de passe"]) ?>
                            </div>
                            <div class="col-xs-12 col-md-4 input-field">
                                <?= $this->Form->input('confirm', ['type' => 'password', 'required' => true, 'aria-required' => true, 'label' => "Confirmation"]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-action right-align">
                        <?= $this->Form->button("<i class='material-icons left'>check</i> Sauvegarder", ['class' => 'btn green waves-effect waves-light']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
    <!-- Orders history -->
    <div class="row">
        <div class="col-xs-12">
            <?= $this->element('orders', [
                'orders' => $orders,
                'actions' => $this->Html->link("<i class='material-icons right'>navigate_next</i> Tout afficher", ['_name' => 'orders:index'], ['class' => 'btn blue waves-effect waves-light right', 'escape' => false])
            ]) ?>
        </div>
    </div>
</div>
<div id="deleteConfirm" class="modal">
    <div class="modal-content">
        <h5 class="red-text"><?= __("Êtes-vous sûr de vouloir supprimer votre compte ?") ?></h5>
        <p><?= __("La suppression de votre compte est définitive et irréversible. La suppression de votre compte entraînera la suppression de toutes vos activités sur le site.") ?></p>
    </div>
    <div class="modal-footer">
        <?= $this->Form->postLink("<i class='material-icons left'>delete_forever</i> Confirmer", ['_name' => 'users:delete'], ['method' => 'delete', 'class' => 'btn-flat waves-effect waves-red red-text', 'escape' => false, 'title' => "Confirmer la suppression", 'target' => '_self']) ?>
        <a href="#!" class="modal-action modal-close waves-effect btn-flat">Annuler</a>
    </div>
</div>
