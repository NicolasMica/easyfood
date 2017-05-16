<?php

if (isset($resto)) {
    $this->assign('title', "Modifier le restaurant $resto->name");
} else {
    $this->assign('title', "Ajouter un nouveau restaurant");
}

$this->Html->script('tags', ['block' => true]);

?>

<div class="container">
    <div class="row">
        <!-- Restaurant -->
        <div class="col-xs-12 col-sm-8">
            <div class="card">
                <?= $this->Form->create($resto) ?>
                <?php $this->Form->unlockField('dish_types');  ?>
                <div class="card-content">
                    <span class="card-title"><?= $this->fetch('title') ?></span>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 input-field">
                            <?= $this->Form->control('name', ['label' => "Nom du restaurant", 'required' => true, 'aria-required' => true]) ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 input-field">
                            <?= $this->Form->select('city_id', $cities, ['label' => false, 'required' => true, 'aria-required' => true]) ?>
                            <label>Ville du restaurant</label>
                            <?php if ($this->Form->isFieldError('city_id')) echo $this->Form->error('city_id'); ?>
                        </div>
                        <div class="col-xs-12 input-field">
                            <?= $this->Form->control('address', ['label' => "Adresse du restaurant", 'required' => true, 'aria-required' => true]) ?>
                        </div>
                        <div id="tags" class="col-xs-12 input-field">
                            <tags label="Types de plats du restaurant" name="dish_types" :tags='<?= json_encode($dish_types) ?>' :value='<?= json_encode($types) ?>' placeholder="Ajouter un tag"></tags>
                            <?php if ($this->Form->isFieldError('dish_types')) echo $this->Form->error('dish_types'); ?>
                        </div>
                        <div class="col-xs-12 input-field">
                            <?= $this->Form->control('description', ['label' => "Description du restaurant", 'class' => 'materialize-textarea']) ?>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row center-xs between-sm">
                        <div class="col-xs-12 col-sm-6 col-lg-5">
                            <?= $this->Html->link("<i class='material-icons'>close</i> Annuler", ['_name' => 'resto:view'], ['class' => 'btn-flat btn-fill red-text waves-effect', 'escape' => false]) ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-lg-5">
                            <?= $this->Form->button("<i class='material-icons'>check</i> Sauvegarder", ['class' => 'btn-flat btn-fill green-text waves-effect', 'escape' => false]) ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
        <!-- Dishes -->
        <div class="col-xs-12 col-sm-4">
            <ul class="collection with-header">
                <li class="collection-header flow-text">Plats du restaurant</li>
                <?php if (isset($resto) && $resto->dishes): ?>
                    <?php foreach ($resto->dishes as $dish): ?>
                        <li class="collection-item avatar">
                            <div class="circle" style="background-image: url(<?= $dish->picture ?>)"></div>
                            <span><?= $dish->name ?></span>
                            <p><small class="grey-text text-darken-1"><?= $dish->dish_type->name ?></small></p>
                            <div class="secondary-content right-align">
                                <span class="green-text"><?= $dish->selling_price ?> €</span>
                                <br>
                                <?= $this->Html->link("<i class='material-icons amber-text waves-effect'>edit</i>", ['_name' => 'dishes:edit', 'id' => $dish->id], ['escape' => false]) ?>
                                <?= $this->Form->postLink("<i class='material-icons red-text waves-effect'>delete</i>", ['_name' => 'dishes:delete', 'id' => $dish->id], ['escape' => false, 'confirm' => "Voulez-vous réellement supprimer le plat $dish->name ?"]) ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="collection-item">Aucun plat associé à ce restaurant pour l'instant.</li>
                <?php endif; ?>
                <?= $this->Html->link("<i class='material-icons'>add</i> AJOUTER UN PLAT", ['_name' => 'dishes:add'], ['escape' => false, 'class' => 'collection-item green-text waves-effect center-align']) ?>
            </ul>
        </div>
    </div>
</div>
