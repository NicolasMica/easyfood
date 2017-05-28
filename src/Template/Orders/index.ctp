<?php $this->assign('title', __("Historique des commandes")) ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?= $this->element('orders', ['orders' => $orders]) ?>
        </div>
    </div>
    <?= $this->element('paginate') ?>
</div>
