<?php

if ($review->isNew()) {
    $this->assign('title', "Ajouter un avis pour la commande n°{$review->order->id}");
} else {
    $this->assign('title', "Modifier l'avis de la commande n°{$review->order->id}");
}

$this->Html->script($this->Asset->path('/js/reviews.js'), ['block' => true]);

?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?= $this->element('order', [
                'title' => "Détails de  la commande n°{$review->order->id}",
                'order' => $review->order
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <?= $this->Form->create($review) ?>
                <?php
                    $this->Form->unlockField('quality');
                    $this->Form->unlockField('recipe');
                    $this->Form->unlockField('design');
                    $this->Form->unlockField('price');
                    $this->Form->unlockField('delivery');
                    $this->Form->unlockField('employee');
                ?>
                    <div class="card-content">
                        <span class="card-title">Votre avis</span>
                        <div id="reviews" class="row">
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <rate name="quality" label="Qualité du plat" :value="<?= $review->quality ?: 0 ?>"></rate>
                                <?php if ($this->Form->isFieldError('quality')) echo $this->Form->error('quality'); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <rate name="recipe" label="Respect de la recette" :value="<?= $review->recipe ?: 0 ?>"></rate>
                                <?php if ($this->Form->isFieldError('recipe')) echo $this->Form->error('recipe'); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <rate name="design" label="Esthétique du plat" :value="<?= $review->design ?: 0 ?>"></rate>
                                <?php if ($this->Form->isFieldError('design')) echo $this->Form->error('design'); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <rate name="price" label="Prix du plat" :value="<?= $review->price ?: 0 ?>"></rate>
                                <?php if ($this->Form->isFieldError('price')) echo $this->Form->error('price'); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <rate name="delivery" label="Délais de livraison" :value="<?= $review->delivery ?: 0 ?>"></rate>
                                <?php if ($this->Form->isFieldError('delivery')) echo $this->Form->error('delivery'); ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <rate name="employee" label="Courtoisie du livreur" :value="<?= $review->employee ?: 0 ?>"></rate>
                                <?php if ($this->Form->isFieldError('employee')) echo $this->Form->error('employee'); ?>
                            </div>
                        </div>
                        <div class="input-field">
                            <?= $this->Form->control('content', ['class' => 'materialize-textarea', 'required' => false, 'aria-required' => 'true', 'label' => "Commentaire"]) ?>
                        </div>
                    </div>
                    <div class="card-action clearfix">
                        <a href="<?= $this->Url->build(['_name' => 'orders:index'])?>" class="btn waves-effect waves-light red left">
                            <i class="material-icons left">close</i> Annuler
                        </a>
                        <?= $this->Form->button("<i class='material-icons left'>check</i> Suavegarder", ['escape' => false, 'class' => 'btn waves-effect waves-light green right']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
