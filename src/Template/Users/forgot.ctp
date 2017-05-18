<?php $this->assign('title', "Mot de passe oublié") ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <?= $this->Form->create(null) ?>
                    <div class="card-content no-row-marg">
                        <span class="card-title">Demande de réinitialisation de mot de passe</span>
                        <div class="input-field">
                            <?= $this->Form->control('email', ['required' => true, 'aria-required' => true, 'label' => 'Adresse e-mail']) ?>
                            <?php if (!empty($errors)): ?>
                                <div class="input-help">
                                    <?= implode("<br>", $errors['email']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-action clearfix">
                        <?= $this->Html->link("J'ai retrouvé mon mot de passe", ['_name' => 'users:sign'], ['class' => 'btn waves-effect waves-light red']) ?>
                        <?= $this->Form->button("<i class='material-icons left'>send</i> Envoyer", ['class' => 'btn waves-effect waves-light green right']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
