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
                            <?php if ($this->request->session()->read('Auth.User.role.level') == 1): ?>
                                <li  <?= ($this->request->controller == 'Restaurants') ? 'class="active"' : null ?>>
                                    <a href="<?= $this->Url->build(['_name' => 'resto:view']) ?>" title="Mes restaurants" target="_self">
                                        <i class="material-icons left">location_city</i> Mes restaurants
                                    </a>
                                </li>
                            <?php endif; ?>
                            <!-- Profile -->
                            <li  <?= ($this->request->here == $this->Url->build(['_name' => 'users:profile'])) ? 'class="active"' : null ?>>
                                <a href="<?= $this->Url->build(['_name' => 'users:profile']) ?>" title="Préférences" target="_self">
                                    <i class="material-icons">person</i>
                                </a>
                            </li>
                            <!-- Orders -->
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
                    <?= $this->cell('Admin')->render('navbar') ?>
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
                        <li><a class="subheader">Utilisateur</a></li>
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
                                    <i class="material-icons left">person</i> Connexion
                                </a>
                            </li>
                        <?php endif; ?>
                        <?= $this->cell('Admin')->render('sidebar') ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
