<?php $this->assign('title', "Découvrez nos plats") ?>

<div class="container">
    <div class='row'>
        <?php foreach ($dishes as $i => $dish): ?>
<!--            --><?php //if ($i % 3 === 0) echo "</div><div class='row'>" ?>
            <div class="col s12 m6 l4">
                <div class="card">
                    <div class="card-image">
                        <?= $this->Html->image($dish->picture, ['alt' => $dish->name]) ?>
                        <span class="card-title"><?= $dish->name ?></span>
                    </div>
                    <div class="card-content">
                        <p class="strong-text"><?= $this->Html->link($dish->restaurant->name, ['_name' => 'resto:view', 'slug' => $dish->restaurant->slug, 'id' => $dish->restaurant->id], ['class' => 'black-text', 'escape' => false]) ?></p>
                        <p>
                            <span class="green-text flow-text right"><?= $dish->selling_price ?> €</span>
                            <span class="grey-text text-darken-2"><?= $dish->dish_type->name ?></span>
                        </p>

                    </div>
                    <div class="card-action right-align">
                        <a href="#">En savoir plus</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if ($this->Paginator->numbers()): ?>
        <div class="row">
            <div class="col s12">
                <div class="card-panel card-thin center-align">
                    <ul class="pagination">
                        <?= $this->Paginator->prev("<i class='material-icons'>chevron_left</i>", ['escape' => false]) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next("<i class='material-icons'>chevron_right</i>", ['escape' => false]) ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
