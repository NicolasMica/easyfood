<?php $this->assign('title', "Mes restaurants"); ?>

<div class="container">
    <div class="row">
        <?php if (count($restaurants)): ?>
            <div class="col-xs-12 right-align">
                <?= $this->Html->link("<i class='large material-icons'>add</i> Ajouter un nouveau restaurant", ['_name' => 'resto:add'], ['escape' => false, 'class' => 'btn waves-effect waves-light green']) ?>
            </div>
            <?php foreach ($restaurants as $resto): ?>
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title"><?= $resto->name ?></span>
                            <p><?= $this->Text->truncate($resto->description, 140, ['exact' => false]) ?></p>
                        </div>
                        <div class="card-action clearfix">
                            <?= $this->Form->postLink("<i class='material-icons'>delete</i> Supprimer", ['_name' => 'resto:delete', 'id' => $resto->id], ['class' => 'btn waves-effect waves-light red left', 'escape' => false, 'confirm' => "Êtes-vous sûr de vouloir supprimer définitivement le restaurant $resto->name ?"]) ?>
                            <?= $this->Html->link("<i class='material-icons'>mode_edit</i> Modifier", ['_name' => 'resto:edit', 'id' => $resto->id], ['class' => 'btn waves-effect waves-light amber right', 'escape' => false]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Nouveau restaurant</span>
                        <p>Vous n'avez ajouté aucun restaurant pour l'instant. Souhaitez vous en ajouter un maintenant ? Cliquez sur le bouton <b>ajouter</b> ci-dessous.</p>
                    </div>
                    <div class="card-action right-align">
                        <?= $this->Html->link("<i class='material-icons left'>add</i> Ajouter", ['_name' => 'resto:add'], ['escape' => false, 'class' => 'btn green waves-effect waves-light']) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
