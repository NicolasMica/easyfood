<?php $this->assign('title', "Gestion des plats"); ?>

<div class="container">
    <div class="row">
        <?php if ($dishes->count()): ?>
        <?php foreach ($dishes as $dish): ?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-image">
                        <img src="<?= $dish->picture ?>" alt="<?= $dish->name ?>">
                        <span class="card-title"><?= $dish->name ?></span>
                    </div>
                    <div class="card-content">
                        <span class="strong-text black-text"><?= $dish->restaurant->name ?></span>
                        <p>
                            <span class="green-text flow-text right"><?= $dish->selling_price ?> €</span>
                            <span class="grey-text text-darken-2"><?= $dish->dish_type->name ?></span>
                        </p>
                    </div>
                    <div class="card-action clearfix">
                        <a href="<?= $this->Url->build(['_name' => 'admin:dishes:save', 'dish' => $dish->id]) ?>" class="btn waves-effect waves-light red left" title="Invalider">
                            <i class="material-icons">close</i>
                        </a>
                        <?= $this->Form->postLink('<i class="material-icons">check</i>', ['_name' => 'admin:dishes:validate', 'dish' => $dish->id], ['class' => 'btn waves-effect waves-light green right', 'title' => "Valider", 'escape' => false]) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
            <div class="col-xs-12">
                <div class="card-panel flow-text">
                    Il n'y a aucun plats à valider pour l'instant.
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?= $this->element('paginate') ?>
</div>
