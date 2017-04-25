<?php $this->assign('title', "Page introuvable"); ?>

<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <h4><?= $this->fetch('title') ?></h4>
                <p>La page à laquelle vous essayez d'accéder semble ne pas exister. Vérifiez le lien dans la barre de navigation.</p>
                <p>Vous essayez peut-être d'accèder à l'une de ces pages:</p>
                <?= $this->Html->link("<i class='material-icons left'>arrow_back</i> Page précédente", 'javascript:history.back()', ['class' => 'btn-large waves-effect', 'escape' => false]) ?>
                <?= $this->Html->link("<i class='material-icons left'>restaurant</i> Accueil", ['_name' => 'plats'], ['class' => 'btn-large waves-effect', 'escape' => false]) ?>
                <?= $this->Html->link("<i class='material-icons left'>location_city</i> Restaurants", ['_name' => 'resto:index'], ['class' => 'btn-large waves-effect', 'escape' => false]) ?>
                <?php if ($this->request->session()->check('Auth.User')): ?>
                    <?= $this->Html->link("<i class='material-icons left'>person</i> Préférences", ['_name' => 'users:profile'], ['class' => 'btn-large waves-effect', 'escape' => false]) ?>
                <?php else: ?>
                    <?= $this->Html->link(__("Connexion & Inscription"), ['_name' => 'users:sign'], ['class' => 'btn-large waves-effect', 'escape' => false]) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
