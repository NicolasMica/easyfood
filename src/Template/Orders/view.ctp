<?php $this->assign('title', "Commande n°$order->id"); ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?= $this->element('order', compact('order') + ['back' => true]) ?>
        </div>
    </div>
</div>
