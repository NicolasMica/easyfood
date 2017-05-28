<?php $this->assign('title', "Invalider le plat {$dish->name}"); ?>

<?php $this->Html->scriptStart(['block' => true]); ?>
    $(document).ready(function () {
        $('.materialboxed').materialbox();
    });
<?php $this->Html->scriptEnd(); ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title"><?= $this->fetch('title') ?></span>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 input-field">
                            <label class="active">Nom du restaurant</label>
                            <input type="text" value="<?= $dish->restaurant->name ?>" disabled="disabled" readonly="readonly">
                        </div>
                        <div class="col-xs-12 col-sm-6 input-field">
                            <label class="active">Nom du plat</label>
                            <input type="text" value="<?= $dish->name ?>" disabled="disabled" readonly="readonly">
                        </div>
                        <div class="col-xs-12 col-sm-4 img-container input-field">
                            <?= $this->Html->image($dish->picture, ['alt' => $dish->name, 'class' => 'materialboxed']) ?>
                        </div>
                        <div class="col-xs-12 col-sm-8 input-field">
                            <textarea class="materialize-textarea" disabled="disabled" readonly="readonly"><?= $dish->description ?></textarea>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-lg-4 input-field">
                            <label class="active">Type de plat</label>
                            <input type="text" value="<?= $dish->dish_type->name ?>" disabled="disabled" readonly="readonly">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-lg-4 input-field">
                            <label class="active">Prix fournisseur</label>
                            <input type="text" value="<?= $dish->supplier_price ?> €" disabled="disabled" readonly="readonly">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-lg-4 input-field">
                            <label class="active">Prix client</label>
                            <input type="text" value="<?= $dish->selling_price ?> €" disabled="disabled" readonly="readonly">
                        </div>
                    </div>
                </div>
                <?= $this->Form->create($rejected_dish) ?>
                <div class="card-content">
                    <div class="input-field">
                        <?= $this->Form->control('content', ['label' => "Raison de l'invalidation", 'required' => true, 'aria-required' => 'true', 'class' => 'materialize-textarea']) ?>
                    </div>
                </div>
                <div class="card-action clearfix">
                    <a href="<?= $this->Url->build(['_name' => 'admin:dishes:index']) ?>" class="btn waves-effect waves-light red left">
                        <i class="material-icons">close</i> Annuler
                    </a>
                    <?= $this->Form->button("<i class='material-icons right'>send</i> Envoyer", ['escape' => false, 'class' => 'btn waves-effect waves-light green right']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
    <?php if ($dish->rejected_dishes): ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Historique des invalidations</span>
                        <table class="striped bordered table-responsive">
                            <thead>
                            <tr>
                                <th>
                                    Raison
                                </th>
                                <th>
                                    Date
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($dish->rejected_dishes as $reject): ?>
                                <tr>
                                    <td><?= $reject->content ?></td>
                                    <td><?= "Le {$reject->created->format("d/m/Y")} à {$reject->created->format("H:i")}" ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
