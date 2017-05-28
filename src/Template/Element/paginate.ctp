<?php if ($this->Paginator->numbers()): ?>
    <div class="row center-xs">
        <div class="card-panel card-thin">
            <ul class="pagination">
                <?= $this->Paginator->prev('<i class="material-icons">navigate_before</i>', ['escape' => false]) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('<i class="material-icons">navigate_next</i>', ['escape' => false]) ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
