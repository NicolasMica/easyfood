<div class="card">
    <div class="card-content clearfix">
        <?php if (isset($back) && $back): ?>
            <?= $this->Html->link("<i class='material-icons left'>arrow_back</i> Retour", $this->request->referer(), ['class' => 'btn-flat blue-text waves-effect right', 'escape' => false]) ?>
        <?php endif; ?>
        <span class="card-title"><?= isset($title) ? $title : $this->fetch('title') ?></span>
        <div class="row">
            <div class="col-xs-12 col-sm-6 input-field">
                <label class="active">Méthode de paiement</label>
                <input type="text" value="<?= $order->payment ? 'Espece' : 'Carte bancaire' ?>" readonly="readonly">
            </div>
            <div class="col-xs-12 col-sm-6 input-field">
                <label class="active">Montant de la commande</label>
                <input type="text" value="<?= $order->total . ' €' ?>" readonly="readonly">
            </div>
            <div class="col-xs-12 col-sm-6 input-field">
                <label class="active">Date de le commande</label>
                <input type="text" value="<?= $order->created->format('d/m/Y H:i') ?>" readonly="readonly">
            </div>
            <div class="col-xs-12 col-sm-6 input-field">
                <label class="active">Date de la livraison</label>
                <input type="text" value="<?= $order->date->format('d/m/Y H:i') ?>" readonly="readonly">
            </div>
        </div>
        <table class="bordered striped responsive-table">
            <thead>
            <tr>
                <th>Nom du plat</th>
                <th>Type de plat</th>
                <th>Restaurant</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Prix total</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($order->dishes as $dish): ?>
                <tr>
                    <td><?= $dish->name ?></td>
                    <td><?= $dish->dish_type->name ?></td>
                    <td><?= $dish->restaurant->name ?></td>
                    <td><?= $dish->_joinData->amount ?></td>
                    <td><?= $dish->selling_price ?> €</td>
                    <td><?= $dish->selling_price * $dish->_joinData->amount ?> €</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if (isset($actions)): ?>
        <div class="card-action clearfix">
            <?= $actions ?>
        </div>
    <?php endif; ?>
</div>
