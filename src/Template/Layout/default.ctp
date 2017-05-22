<!DOCTYPE html>
<html lang="fr" prefix="og: http://ogp.me/ns#">
<head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="content-language" content="fr" />
    <meta name="language" content="fr" />
    <meta name="copyright" content="<?= $this->Url->build('/', ['fullBase' => true]) ?>" />
    <meta name="author" content="Nicolas Micallef <nicolas@micallef.pro>" />

    <meta name="theme-color" content="#4CAF50" />
    <meta name="msapplication-navbutton-color" content="#4CAF50" />
    <meta name="apple-mobile-web-app-status-bar-style" content="#4CAF50" />

    <meta name="description" content="<?= $this->fetch('description', "Commandez tous vos plats à petit prix et en un instant grâce à EasyFood !") ?>"/>

    <!-- OpenGraph -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?= $this->Url->build('/', ['fullBase' => true]) ?>" />
    <meta property="og:title" content="EasyFood: <?= $this->fetch('title') ?>" />
    <meta property="og:description" content="<?= $this->fetch('description', "Commandez tous vos plats à petit prix et en un instant grâce à EasyFood !") ?>" />
    <meta property="og:image" content="<?= $this->Url->build('/img/logo.png', ['fullBase' => true]) ?>" />
    <meta property="og:image:secure_url" content="<?= $this->Url->build('/img/logo.png', ['fullBase' => true]) ?>" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="206" />
    <meta property="og:image:height" content="206" />

    <!-- Twitter Card -->
    <meta property="twitter:card" content="summary" />
    <meta property="twitter:url" content="<?= $this->Url->build('/', ['fullBase' => true]) ?>" />
    <meta property="twitter:title" content="EasyFood: <?= $this->fetch('title') ?>" />
    <meta property="twitter:description" content="<?= $this->fetch('description', "Commandez tous vos plats à petit prix et en un instant grâce à EasyFood !") ?>" />
    <meta property="twitter:image" content="<?= $this->Url->build('/img/logo.png', ['fullBase' => true]) ?>" />

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
        <div class="col-xs-12">
            <nav class="nav-top">
                <div class="nav-wrapper green">
                    <a href="<?= $this->Url->build('/') ?>" class="brand-logo" title="EasyFood" target="_self">EasyFood</a>
                    <a href="#" data-activates="mobile-demo" class="button-collapse" title="Navigation"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li  <?= ($this->request->here == $this->Url->build(['_name' => 'plats'])) ? 'class="active"' : null ?>>
                            <a href="<?= $this->Url->build(['_name' => 'plats']) ?>" title="Accueil" target="_self">
                                <i class="material-icons left" aria-hidden="true">restaurant</i> Accueil
                            </a>
                        </li>
                        <?php if($this->request->session()->check('Auth.User')): ?>
                            <?php if ($this->request->session()->read('Auth.User.role_id') <= 3): ?>
                                <li  <?= ($this->request->controller == 'Restaurants') ? 'class="active"' : null ?>>
                                    <a href="<?= $this->Url->build(['_name' => 'resto:view']) ?>" title="Mes restaurants" target="_self">
                                        <i class="material-icons left">location_city</i> Mes restaurants</a>
                                </li>
                            <?php endif; ?>
                            <li  <?= ($this->request->here == $this->Url->build(['_name' => 'users:profile'])) ? 'class="active"' : null ?>>
                                <a href="<?= $this->Url->build(['_name' => 'users:profile']) ?>" title="Préférences" target="_self">
                                    <i class="material-icons">person</i>
                                </a>
                            </li>
                            <li  <?= ($this->request->controller == 'orders') ? 'class="active"' : null ?>>
                                <a href="<?= $this->Url->build(['_name' => 'orders:index']) ?>" title="Commandes" target="_self">
                                    <i class="material-icons">shopping_basket</i>
                                </a>
                            </li>
                            <li>
                                <?= $this->Form->postLink("<i class='material-icons'>power_settings_new</i>", ['_name' => 'users:logout'], ['escape' => false, 'title' => 'Déconnexion', 'target' => '_self']) ?>
                            </li>
                        <?php else: ?>
                            <li  <?= ($this->request->here == $this->Url->build(['_name' => 'users:sign'])) ? 'class="active"' : null ?> >
                                <a href="<?= $this->Url->build(['_name' => 'users:sign']) ?>" title="Connexion" target="_self">
                                    <i class="material-icons left">person</i> Connexion</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <ul class="side-nav" id="mobile-demo">
                        <li><a class="subheader">Navigation</a></li>
                        <li  <?= ($this->request->here == $this->Url->build(['_name' => 'plats'])) ? 'class="active"' : null ?>>
                            <a href="<?= $this->Url->build(['_name' => 'plats']) ?>" title="Accueil" target="_self">
                                <i class="material-icons left" aria-hidden="true">restaurant</i> Accueil
                            </a>
                        </li>
                        <?php if ($this->request->session()->check('Auth.User') && $this->request->session()->read('Auth.User.role_id') === 3): ?>
                            <li  <?= ($this->request->controller == 'Restaurants') ? 'class="active"' : null ?>>
                                <a href="<?= $this->Url->build(['_name' => 'resto:view']) ?>" title="Mes restaurants" target="_self">
                                    <i class="material-icons left">location_city</i> Mes restaurants</a>
                            </li>
                        <?php endif; ?>
                        <li><div class="divider"></div></li>
                        <li>
                            <a class="subheader">Utilisateur</a></li>
                        <?php if($this->request->session()->check('Auth.User')): ?>
                            <li  <?= ($this->request->here == $this->Url->build(['_name' => 'users:profile'])) ? 'class="active"' : null ?>>
                                <a href="<?= $this->Url->build(['_name' => 'users:profile']) ?>" title="Préférences" target="_self">
                                    <i class="material-icons left">person</i> Préférences</a>
                            </li>
                            <li  <?= ($this->request->controller == 'orders') ? 'class="active"' : null ?>>
                                <a href="<?= $this->Url->build(['_name' => 'orders:index']) ?>" title="Commandes" target="_self">
                                    <i class="material-icons left">shopping_basket</i> Commandes</a>
                            </li>
                            <li>
                                <?= $this->Form->postLink("<i class='material-icons left'>power_settings_new</i> Déconnexion", ['_name' => 'users:logout'], ['escape' => false, 'title' => 'Déconnexion', 'target' => '_self']) ?>
                            </li>
                        <?php else: ?>
                            <li  <?= ($this->request->here == $this->Url->build(['_name' => 'users:sign'])) ? 'class="active"' : null ?> >
                                <a href="<?= $this->Url->build(['_name' => 'users:sign']) ?>" title="Connexion" target="_self">
                                    <i class="material-icons left">person</i> Connexion</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>

<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <footer class="page-footer green">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-7 col-md-6">
                            <h5 class="white-text">&Agrave; Propos</h5>
                            <p class="grey-text text-lighten-4">Site développé en utilisant le langage <?= $this->Html->link('PHP', 'http://php.net/', ['class' => 'green-text text-lighten-5 strong-text', 'title' => "PHP", 'target' => '_blank']) ?> avec le framework <?= $this->Html->link('CakePHP', 'https://cakephp.org/', ['class' => 'green-text text-lighten-5 strong-text', 'title' => "CakePHP", 'target' => '_blank']) ?>. La base de données est gérée par <?= $this->Html->link('MySQL', 'https://www.mysql.fr/', ['class' => 'green-text text-lighten-5 strong-text', 'title' => "MySQL", 'target' => '_blank']) ?>. L'interface est réalisée à l'aide de <?= $this->Html->link('Materialize', 'https://materializecss.com/', ['class' => 'green-text text-lighten-5 strong-text', 'title' => "Materialize", 'target' => '_blank']) ?>, <?= $this->Html->link('Flexbox Grid', 'https://flexboxgrid.org/', ['class' => 'green-text text-lighten-5 strong-text', 'title' => "Flexbox Grid", 'target' => '_blank']) ?> ainsi que <?= $this->Html->link('VueJs', 'https://vuejs.org/', ['class' => 'green-text text-lighten-5 strong-text', 'title' => "VueJs", 'target' => '_blank']) ?>. Le tout est transpilé  à l'aide de <?= $this->Html->link('Laravel Mix', 'https://github.com/JeffreyWay/laravel-mix', ['class' => 'green-text text-lighten-5 strong-text', 'title' => "Laravel Mix", 'target' => '_blank']) ?>.</p>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-sm-offset-1 col-md-4 col-md-offset-2">
                            <h5 class="white-text">Liens utiles</h5>
                            <ul>
                                <li>
                                    <?= $this->Html->link('CakePHP', 'https://cakephp.org/', ['class' => 'green-text text-lighten-5', 'title' => "CakePHP", 'target' => '_blank']) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link('Materialize', 'https://materializecss.com/', ['class' => 'green-text text-lighten-5', 'title' => "Materialize", 'target' => '_blank']) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link('Flexbox Grid', 'https://flexboxgrid.org/', ['class' => 'green-text text-lighten-5', 'title' => "Flexbox Grid", 'target' => '_blank']) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link('VueJs', 'https://vuejs.org/', ['class' => 'green-text text-lighten-5', 'title' => "VueJs", 'target' => '_blank']) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link('Laravel Mix', 'https://github.com/JeffreyWay/laravel-mix', ['class' => 'green-text text-lighten-5', 'title' => "Laravel Mix", 'target' => '_blank']) ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer-copyright">
                    <div class="container">
                        © <?= date('Y') ?> EasyFood
                        <a class="grey-text text-lighten-4 right" href="mailto:nicolas@micallef.pro" title="Nicolas Micallef">Nicolas Micallef</a>
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
