<?php $this->assign('title', "Réinitialisation de mot de passe"); ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <?= $this->Form->create($user) ?>
                    <div class="card-content no-row-marg">
                        <span class="card-title"><?= $this->fetch('title') ?></span>
                        <div class="row">
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->control('password', ['required' => true, 'aria-required' => true, 'label' => "Nouveau mot de passe", 'value' => false]) ?>
                            </div>
                            <div class="col-xs-12 col-md-6 input-field">
                                <?= $this->Form->control('confirm', ['type' => 'password', 'required' => true, 'aria-required' => true, 'label' => "Confirmation"]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-action clearfix">
                        <?= $this->Html->link("J'ai retrouvé mon mot de passe", ['_name' => 'users:sign'], ['class' => 'btn-flat waves-effect red-text']) ?>
                        <?= $this->Form->button("<i class='material-icons left'>check</i> Sauvegarder", ['class' => 'btn-flat green-text right']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
