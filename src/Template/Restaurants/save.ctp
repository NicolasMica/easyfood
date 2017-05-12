<?php

if (isset($resto)) {
    $this->assign('title', "Modifier le restaurant $resto->name");
} else {
    $this->assign('title', "Ajouter un nouveau restaurant");
}

?>


<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <?= $this->Form->create($resto) ?>
                <div class="card-content">
                    <span class="card-title"><?= $this->fetch('title') ?></span>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-lg-4 input-field">
                            <?= $this->Form->control('name', ['label' => "Nom du restaurant", 'required' => true, 'aria-required' => true]) ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-lg-4 input-field">
                            <?= $this->Form->control('address', ['label' => "Adresse du restaurant", 'required' => true, 'aria-required' => true]) ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-lg-4 input-field">
                            <?= $this->Form->select('city_id', $cities, ['label' => false, 'required' => true, 'aria-required' => true]) ?>
                            <label>Ville du restaurant</label>
                            <?php if ($this->Form->isFieldError('city_id')) echo $this->Form->error('city_id'); ?>
                        </div>
                        <div class="col-xs-12 input-field">
                            <?= $this->Form->input('dish_types', ['label' => "Types de plats du restaurant", "value" => implode(', ', $dish_types)]) ?>
                            <?php if ($this->Form->isFieldError('dish_types')) echo $this->Form->error('dish_types'); ?>
                        </div>
                        <div class="col-xs-12 input-field">
                            <?= $this->Form->control('description', ['label' => "Description du restaurant", 'class' => 'materialize-textarea']) ?>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row center-xs between-sm">
                        <div class="col-xs-12 col-sm-4 col-lg-3">
                            <?= $this->Html->link("<i class='material-icons'>close</i> Annuler", ['_name' => 'resto:view'], ['class' => 'btn-flat btn-fill red-text waves-effect', 'escape' => false]) ?>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-lg-3">
                            <?= $this->Form->button("<i class='material-icons'>check</i> Sauvegarder", ['class' => 'btn-flat btn-fill green-text waves-effect', 'escape' => false]) ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
