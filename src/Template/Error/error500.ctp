<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?php if ($error instanceof Error) : ?>
        <strong>Error in: </strong>
        <?= sprintf('%s, line %s', str_replace(ROOT, 'ROOT', $error->getFile()), $error->getLine()) ?>
<?php endif; ?>
<?php
    echo $this->element('auto_table_warning');

    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
?>
    <h2><?= __d('cake', 'An Internal Error Has Occurred') ?></h2>
    <p class="error">
        <strong><?= __d('cake', 'Error') ?>: </strong>
        <?= h($message) ?>
    </p>
<?php else: ?>
    <?php $this->assign('title', "Erreur interne"); ?>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="card-panel">
                    <h4><?= $this->fetch('title') ?></h4>
                    <p>Une erreur s'est produite. Veuillez essayer à nouveau ultérieurement. Si le problème persiste veuillez contacter un administrateur du site afin de signaler le problème.</p>
                    <p>En attendant vous souhaitez peut-être accèder à l'une de ces pages:</p>
                    <?= $this->Html->link("<i class='material-icons left'>arrow_back</i> Page précédente", 'javascript:history.back()', ['class' => 'btn-large waves-effect', 'escape' => false, 'title' => "Page précédente", 'target' => '_self']) ?>
                    <?= $this->Html->link("<i class='material-icons left'>restaurant</i> Accueil", ['_name' => 'plats'], ['class' => 'btn-large waves-effect', 'escape' => false, 'title' => "Accueil", 'target' => '_self']) ?>
                    <?php if ($this->request->session()->check('Auth.User')): ?>
                        <?php if ($this->request->session()->check('Auth.User.role_id') <= 3): ?>
                            <?= $this->Html->link("<i class='material-icons left'>location_city</i> Mes restaurants", ['_name' => 'resto:index'], ['class' => 'btn-large waves-effect', 'escape' => false, 'title' => "Mes restaurants", 'target' => '_self']) ?>
                        <?php endif; ?>
                        <?= $this->Html->link("<i class='material-icons left'>person</i> Préférences", ['_name' => 'users:profile'], ['class' => 'btn-large waves-effect', 'escape' => false, 'title' => "Préférences", 'target' => '_self']) ?>
                    <?php else: ?>
                        <?= $this->Html->link(__("Connexion & Inscription"), ['_name' => 'users:sign'], ['class' => 'btn-large waves-effect', 'escape' => false, 'title' => "Connexion & Inscription", 'target' => '_self']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

