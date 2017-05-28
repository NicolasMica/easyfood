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
<?= $this->element('navbar') ?>
<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>
<?= $this->element('footer') ?>

<?= $this->Html->script([
    $this->Asset->path('/js/app.js')
]) ?>

<?= $this->fetch('script') ?>
</body>
</html>
