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
                    <a href="<?= $this->Url->build('/') ?>" class="brand-logo">EASY FOOD</a>
                    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="#"><i class="material-icons left" aria-hidden="true">location_city</i>Villes</a></li>
                        <li><a href="<?= $this->Url->build(['_name' => 'plats']) ?>"><i class="material-icons left" aria-hidden="true">restaurant</i>Plats</a></li>
                        <li><a href="<?= $this->Url->build(['_name' => 'restaurants']) ?>"><i class="material-icons left" aria-hidden="true">home</i> Restaurants</a></li>
                        <li><a href="#"><i class="material-icons left" aria-hidden="true">cake</i>Spécialités</a></li>
                        <?php if($this->request->session()->read('Auth.User')): ?>
                            <li><a href="<?= $this->Url->build(['_name' => 'users:profile']) ?>"><i class="material-icons left">person</i> Mon compte</a></li>
                            <li><a href="<?= $this->Url->build(['_name' => 'users:logout']) ?>"><i class="material-icons left">power_settings_new</i> Déconnexion</a></li>
                        <?php else: ?>
                            <li><a href="<?= $this->Url->build(['_name' => 'users:sign']) ?>"><i class="material-icons left">person</i> Connexion</a></li>
                        <?php endif; ?>
                    </ul>
                    <ul class="side-nav" id="mobile-demo">
                        <li><a href="#"><i class="material-icons left" aria-hidden="true">location_city</i>Villes</a></li>
                        <li><a href="<?= $this->Url->build(['_name' => 'plats']) ?>"><i class="material-icons left" aria-hidden="true">restaurant</i>Plats</a></li>
                        <li><a href="<?= $this->Url->build(['_name' => 'restaurants']) ?>"><i class="material-icons left" aria-hidden="true">home</i> Restaurants</a></li>
                        <li><a href="#"><i class="material-icons left" aria-hidden="true">cake</i>Spécialités</a></li>
                        <?php if($this->request->session()->read('Auth.User')): ?>
                            <li><a href="<?= $this->Url->build(['_name' => 'users:profile']) ?>"><i class="material-icons left">person</i> Mon compte</a></li>
                            <li><a href="<?= $this->Url->build(['_name' => 'users:logout']) ?>"><i class="material-icons left">power_settings_new</i> Déconnexion</a></li>
                        <?php else: ?>
                            <li><a href="<?= $this->Url->build(['_name' => 'users:sign']) ?>"><i class="material-icons left">person</i> Connexion</a></li>
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
                    <form>
                        <div class="input-field">
                            <input id="search" type="search" placeholder="Rechecher..." required>
                            <label class="label-icon" for="search"><i class="material-icons grey-text text-darken-2">search</i></label>
                            <i class="material-icons">close</i>
                        </div>
                    </form>
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
                        <div class="col l6 s12">
                            <h5 class="white-text">&Agrave; Propos</h5>
                            <p class="grey-text text-lighten-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A animi deleniti dolorum error, est et eum fugiat iure libero mollitia natus provident saepe tempora velit voluptates. A repellat tempore velit.</p>
                        </div>
                        <div class="col l4 offset-l2 s12">
                            <h5 class="white-text">Partenaires</h5>
                            <ul>
                                <li><a class="grey-text text-lighten-3" href="#!">Mollitia</a></li>
                                <li><a class="grey-text text-lighten-3" href="#!">Saepe Tempora</a></li>
                                <li><a class="grey-text text-lighten-3" href="#!">Dolor Sit</a></li>
                                <li><a class="grey-text text-lighten-3" href="#!">Voluptates</a></li>
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
