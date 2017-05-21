<?php $this->assign('title', __("Historique des commandes")) ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title"><?= $this->fetch('title') ?></span>
                    <table class="bordered striped responsive-table">
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
                                    <td><?= $this->Html->link("<i class='material-icons'>remove_red_eye</i> Détail", ['_name' => 'orders:view', 'id' => $order->id], ['class' => 'btn-flat blue-text waves-effect', 'escape' => false]) ?></td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
