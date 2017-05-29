<?php

$this->assign('title', "Avis de la commande n°{$review->order->id}");

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
            <?= $this->element('order', [
                'title' => "Détails de  la commande n°{$review->order->id}",
                'order' => $review->order
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Votre avis</span>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="active">Qualité du plat</label>
                            <p><?= review_stars($review->quality) ?></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="active">Respect de la recette</label>
                            <p><?= review_stars($review->recipe) ?></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="active">Esthétique</label>
                            <p><?= review_stars($review->design) ?></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="active">Prix du plat</label>
                            <p><?= review_stars($review->price) ?></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="active">Délais de livraison</label>
                            <p><?= review_stars($review->delivery) ?></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="active">Courtoisie du livreur</label>
                            <p><?= review_stars($review->employee) ?></p>
                        </div>
                    </div>
                    <div class="input-field">
                        <label class="active">Commentaire</label>
                        <textarea class="materialize-textarea" readonly disabled><?= $review->content ?></textarea>
                    </div>
                </div>
                <div class="card-action clearfix">
                    <a href="<?= $this->Url->build(['_name' => 'orders:index'])?>" class="btn waves-effect waves-light blue left">
                        <i class="material-icons left">arrow_back</i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
