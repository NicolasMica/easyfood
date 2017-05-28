<div class="card">
    <div class="card-content">
        <span class="card-title">Historique des commandes</span>
        <table class="bordered striped highlight responsive-table">
            <thead>
            <tr>
                <th>Numéro</th>
                <th>Moyen de paiement</th>
                <th>Date de commande</th>
                <th>Prix</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($orders):
                foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order->id ?></td>
                        <td><?= ($order->payment) ? 'Espece' : 'Carte bancaire' ?></td>
                        <td>Le <?= $order->date->format('d/m/Y') ?> à <?= $order->created->format('H:i') ?></td>
                        <td><?= $order->total ?> €</td>
                        <td>
                            <a href="<?= $this->Url->build(['_name' => 'orders:view', 'id' => $order->id]) ?>" class="btn-flat waves-effect">
                                <i class="material-icons blue-text">remove_red_eye</i> Détail
                            </a>
                            <?php if ($order->review != null && $order->review->active): ?>
                                <a href="<?= $this->Url->build(['_name' => 'reviews:view', 'order' => $order->id]) ?>" class="btn-flat waves-effect">
                                    <i class="material-icons amber-text">star</i> Avis
                                    <i class="material-icons green-text right" title="Validé">check</i>
                                </a>
                            <?php else: ?>
                                <a href="<?= $this->Url->build(['_name' => 'reviews:save', 'order' => $order->id]) ?>" class="btn-flat waves-effect">
                                    <i class="material-icons amber-text">star</i> Avis
                                    <?php if ($order->has('review')): ?>
                                        <?php if ($order->review->pendding): ?>
                                            <i class="material-icons amber-text" title="En attente">access_time</i>
                                        <?php else: ?>
                                            <i class="material-icons red-text" title="Invalidé">close</i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach;
            endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (isset($actions)): ?>
        <div class="card-action clearfix">
            <?= $actions ?>
        </div>
    <?php endif; ?>
</div>
