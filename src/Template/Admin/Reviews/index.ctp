<?php

$this->assign('title', "Gestion des avis");

// Star helper function
if (!function_exists('review_stars')) {
    function review_stars ($nbr) {
        $empty = '<i class="material-icons grey-text text-darken-2">star</i>';
        $plain = '<i class="material-icons amber-text">star</i>';

        return str_repeat($plain, $nbr) . str_repeat($empty, 5 - $nbr);
    }
}

?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title"><?= $this->fetch('title') ?></span>
                    <table class="striped bordered responsive-table">
                        <thead>
                        <tr>
                            <th>N° commande</th>
                            <th>Restaurant</th>
                            <th>Qualité</th>
                            <th>Respect de la recette</th>
                            <th>Esthétique</th>
                            <th>Prix</th>
                            <th>Délais de livraison</th>
                            <th>Courtoisie du livreur</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($reviews as $review): ?>
                            <tr>
                                <td class="center-align"><?= $review->order_id ?></td>
                                <td><?= $review->restaurant->name ?></td>
                                <td><?= review_stars($review->quality) ?></td>
                                <td><?= review_stars($review->recipe) ?></td>
                                <td><?= review_stars($review->design) ?></td>
                                <td><?= review_stars($review->price) ?></td>
                                <td><?= review_stars($review->delivery) ?></td>
                                <td><?= review_stars($review->employee) ?></td>
                                <td>
                                    <a href="<?= $this->Url->build(['_name' => 'admin:reviews:save', 'review' => $review->id]) ?>" class="btn waves-effect waves-light blue" title="Détails" target="_self">
                                        <i class="material-icons">remove_red_eye</i>
                                    </a>
                                    <?= $this->Form->postLink('<i class="material-icons">check</i>', ['_name' => 'admin:reviews:validate', 'review' => $review->id], ['escape' => false, 'class' => 'btn waves-effect waves-light green', 'title' => 'Valider']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?= $this->element('paginate') ?>
</div>
