<?php

if (isset($dish->id)) {
    $this->assign('title', "Modifier le plat $dish->name");
} else {
    $this->assign('title', "Ajouter un nouveau plat");
}

 $this->Html->scriptStart(['block' => true]); ?>
    $(document).ready(function () {
        $('.materialboxed').materialbox();

        var $selling = $('input[name="selling_price"]'),
        $supplier = $('input[name="supplier_price"]');

        $supplier.on('input', function (event) {
            var price = $(this).val() * 1.2 + 1;
            $selling.val(price.toFixed(2));
            Materialize.updateTextFields();
        });

        $selling.on('input', function (event) {
            var price = ($(this).val() - 1) / (1 + 0.2);
            $supplier.val(price.toFixed(2));
            Materialize.updateTextFields();
        });
    });
<?php $this->Html->scriptEnd(); ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <?= $this->Form->create($dish, ['type' => 'file']) ?>
                    <div class="card-content">
                        <span class="card-title"><?= $this->fetch('title') ?></span>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-lg-4 input-field">
                                <label class="active">Restaurant</label>
                                <input type="text" value="<?= $resto->name ?>" disabled="disabled" readonly="readonly">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-lg-4 input-field">
                                <?= $this->Form->control('name', ['label' => "Nom du plat", 'required' => true, 'aria-required' => true]) ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-lg-4 input-field">
                                <?= $this->Form->select('dish_type_id', $dish_types, ['label' => false, 'required' => true, 'aria-required' => true]) ?>
                                <label>Type de plat</label>
                                <?php if ($this->Form->isFieldError('dish_type_id')) echo $this->Form->error('dish_type_id'); ?>
                            </div>
                            <?php if (isset($dish->id)): ?>
                            <div class="col-xs-12 col-sm-6 col-lg-6">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-9 col-lg-8 input-field file-field">
                                        <div class="btn">
                                            <span>Choisir</span>
                                            <?= $this->Form->file('image', ['label' => false, 'class' => false, 'required' => false]) ?>
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path" type="text" placeholder="Photo du plat">
                                        </div>
                                        <?php if ($this->Form->isFieldError('image')) echo $this->Form->error('image'); ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-3 col-lg-4 img-container">
                                        <?= $this->Html->image($dish->picture, ['alt' => $dish->name, 'class' => 'materialboxed']) ?>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                                <div class="col-xs-12 col-sm-6 input-field file-field">
                                    <div class="btn">
                                        <span>Choisir</span>
                                        <?= $this->Form->file('image', ['label' => false, 'class' => false]) ?>
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path" type="text" placeholder="Photo du plat">
                                    </div>
                                    <?php if ($this->Form->isFieldError('image')) echo $this->Form->error('image'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="col-xs-12 col-sm-6 col-lg-3 input-field">
                                <?= $this->Form->control('supplier_price', ['label' => 'Prix de vente à EasyFood', 'required' => true, 'aria-required' => true]) ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-lg-3 input-field">
                                <?= $this->Form->control('selling_price', ['label' => 'Prix de vente au client final', 'required' => true, 'aria-required' => true]) ?>
                            </div>
                            <div class="col-xs-12 input-field">
                                <?= $this->Form->control('description', ['label' => "Description du plat", 'class' => 'materialize-textarea']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-action clearfix">
                        <?= $this->Html->link("<i class='material-icons'>close</i> Annuler", ['_name' => 'resto:edit', 'id' => $resto->id], ['class' => 'btn waves-effect waves-light red left', 'escape' => false, 'title' => "Retour au restaurant", 'target' => '_self']) ?>
                        <?= $this->Form->button("<i class='material-icons'>check</i> Sauvegarder", ['class' => 'btn waves-effect waves-light green right', 'escape' => false]) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
