<?php $this->Html->scriptStart(['block' => true]) ?>

Materialize.toast("<?= $icon . $message ?>", 10000);

<?php $this->Html->scriptEnd() ?>
