<!DOCTYPE html>
<html lang="fr" prefix="og: http://ogp.me/ns#">
<head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyFood: <?= $this->fetch('title') ?> | <?= ucfirst(mb_strtolower($this->request->domain())) ?></title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>

    <?= $this->Html->css([
        $this->Asset->path('/css/app.css')
    ]) ?>
    <?= $this->fetch('css') ?>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col s12">
            <nav class="nav-top">
                <div class="nav-wrapper green">
                    <a href="<?= $this->Url->build('/') ?>" class="brand-logo">EasyFood</a>
                    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li  <?= ($this->request->here == $this->Url->build(['_name' => 'plats'])) ? 'class="active"' : null ?>>
                            <a href="<?= $this->Url->build(['_name' => 'plats']) ?>">
                                <i class="material-icons left" aria-hidden="true">restaurant</i>Plats
                            </a>
                        </li>
                        <li  <?= ($this->request->here == $this->Url->build(['_name' => 'resto:index'])) ? 'class="active"' : null ?>>
                            <a href="<?= $this->Url->build(['_name' => 'resto:index']) ?>">
                                <i class="material-icons left" aria-hidden="true">location_city</i> Restaurants
                            </a>
                        </li>
                        <?php if($this->request->session()->check('Auth.User')): ?>
                            <li  <?= ($this->request->here == $this->Url->build(['_name' => 'users:profile'])) ? 'class="active"' : null ?>>
                                <a href="<?= $this->Url->build(['_name' => 'users:profile']) ?>">
                                    <i class="material-icons left">person</i> Préférences</a>
                            </li>
                            <li>
                                <?= $this->Form->postLink("<i class='material-icons left'>power_settings_new</i> Déconnexion", ['_name' => 'users:logout'], ['escape' => false]) ?>
                            </li>
                        <?php else: ?>
                            <li  <?= ($this->request->here == $this->Url->build(['_name' => 'users:sign'])) ? 'class="active"' : null ?> >
                                <a href="<?= $this->Url->build(['_name' => 'users:sign']) ?>">
                                    <i class="material-icons left">person</i> Connexion</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <ul class="side-nav" id="mobile-demo">
                        <li><a class="subheader">Navigation</a></li>
                        <li  <?= ($this->request->here == $this->Url->build(['_name' => 'plats'])) ? 'class="active"' : null ?>>
                            <a href="<?= $this->Url->build(['_name' => 'plats']) ?>">
                                <i class="material-icons left" aria-hidden="true">restaurant</i>Plats
                            </a>
                        </li>
                        <li  <?= ($this->request->here == $this->Url->build(['_name' => 'resto:index'])) ? 'class="active"' : null ?>>
                            <a href="<?= $this->Url->build(['_name' => 'resto:index']) ?>">
                                <i class="material-icons left" aria-hidden="true">location_city</i> Restaurants
                            </a>
                        </li>
                        <li><div class="divider"></div></li>
                        <li>
                            <a class="subheader">Utilisateur</a></li>
                        <?php if($this->request->session()->check('Auth.User')): ?>
                            <li  <?= ($this->request->here == $this->Url->build(['_name' => 'users:profile'])) ? 'class="active"' : null ?>>
                                <a href="<?= $this->Url->build(['_name' => 'users:profile']) ?>">
                                    <i class="material-icons left">person</i> Préférences</a>
                            </li>
                            <li>
                                <?= $this->Form->postLink("<i class='material-icons left'>power_settings_new</i> Déconnexion", ['_name' => 'users:logout'], ['escape' => false]) ?>
                            </li>
                        <?php else: ?>
                            <li  <?= ($this->request->here == $this->Url->build(['_name' => 'users:sign'])) ? 'class="active"' : null ?> >
                                <a href="<?= $this->Url->build(['_name' => 'users:sign']) ?>">
                                    <i class="material-icons left">person</i> Connexion</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <nav>
                <div class="nav-wrapper white">
                    <?= $this->Form->create(null, ['url' => ['_name' => 'dishes:search']]) ?>
                        <div class="input-field">
                            <?= $this->Form->input('search', [
                                'type' => 'search',
                                'placeholder' => __("Rehcercher..."),
                                'required' => true,
                                'aria-required' => true,
                                'id' => 'search',
                                'label' => false
                            ]) ?>
                            <label class="label-icon" for="search">
                                <i class='material-icons grey-text text-darken-2'>search</i>
                            </label>
                            <i class="material-icons">close</i>
                        </div>
                    <?= $this->Form->end() ?>
                </div>
            </nav>
        </div>
    </div>
</div>

<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>

<div class="container">
    <div class="row">
        <div class="col s12">
            <footer class="page-footer green">
                <div class="container">
                    <div class="row">
                        <div class="col m7 l6 s12">
                            <h5 class="white-text">&Agrave; Propos</h5>
                            <p class="grey-text text-lighten-4">Site développé en utilisant le langage <?= $this->Html->link('PHP', 'http://php.net/', ['class' => 'green-text text-lighten-5 strong-text']) ?> avec le framework <?= $this->Html->link('CakePHP', 'https://cakephp.org/', ['class' => 'green-text text-lighten-5 strong-text']) ?>. La base de données est géré par <?= $this->Html->link('MySQL', 'https://www.mysql.fr/', ['class' => 'green-text text-lighten-5 strong-text']) ?>. L'interface est réalisée à l'aide de <?= $this->Html->link('Materialize', 'https://materializecss.com/', ['class' => 'green-text text-lighten-5 strong-text']) ?>, <?= $this->Html->link('Flexbox Grid', 'https://flexboxgrid.org/', ['class' => 'green-text text-lighten-5 strong-text']) ?> ainsi que <?= $this->Html->link('VueJs', 'https://vuejs.org/', ['class' => 'green-text text-lighten-5 strong-text']) ?>. Le tout est transpilé  à l'aide de <?= $this->Html->link('Laravel Mix', 'https://github.com/JeffreyWay/laravel-mix', ['class' => 'green-text text-lighten-5 strong-text']) ?>.</p>
                        </div>
                        <div class="col m5 l4 offset-l2 s12">
                            <h5 class="white-text">Liens utiles</h5>
                            <ul>
                                <li>
                                    <?= $this->Html->link('CakePHP', 'https://cakephp.org/', ['class' => 'green-text text-lighten-5']) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link('Materialize', 'https://materializecss.com/', ['class' => 'green-text text-lighten-5']) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link('Flexbox Grid', 'https://flexboxgrid.org/', ['class' => 'green-text text-lighten-5']) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link('VueJs', 'https://vuejs.org/', ['class' => 'green-text text-lighten-5']) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link('Laravel Mix', 'https://github.com/JeffreyWay/laravel-mix', ['class' => 'green-text text-lighten-5']) ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer-copyright">
                    <div class="container">
                        © 2016 EasyFood
                        <a class="grey-text text-lighten-4 right" href="#!">Nicolas Micallef</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>

<?= $this->Html->script([
    $this->Asset->path('/js/app.js')
]) ?>

<?= $this->fetch('script') ?>
</body>
</html>
