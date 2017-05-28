<?php if ($this->request->session()->read('Auth.User.role.level') >= 2): ?>
    <ul class="right hide-on-med-and-down">
        <!-- Admin dropdown -->
        <li  <?= ($this->request->prefix == 'admin') ? 'class="active"' : null ?>>
            <a href="#!" class="dropdown-button" data-activates="admin-dropdown" data-belowOrigin="true" data-constrainWidth="false" title="Administration" target="_self">
                <i class="material-icons">settings</i>
            </a>
        </li>
    </ul>
    <ul id="admin-dropdown" class="dropdown-content">
        <li  <?= ($this->request->controller == 'Dishes' && $this->request->prefix == 'admin') ? 'class="active"' : null ?>>
            <a href="<?= $this->Url->build(['_name' => 'admin:dishes:index']) ?>" title="Gestion des plats" target="_self">
                <i class="material-icons">restaurant</i> Gestion des plats
                <?php if ($dishesCount): ?>
                    <span class="new badge red" data-badge-caption=""><?= $dishesCount  ?></span>
                <?php endif; ?>
            </a>
        </li>
        <li  <?= ($this->request->controller == 'Reviews' && $this->request->prefix == 'admin') ? 'class="active"' : null ?>>
            <a href="<?= $this->Url->build(['_name' => 'admin:reviews:index']) ?>" title="Gestion des avis" target="_self">
                <i class="material-icons">star</i> Gestion des avis
                <?php if ($reviewsCount): ?>
                    <span class="new badge red" data-badge-caption=""><?= $reviewsCount  ?></span>
                <?php endif; ?>
            </a>
        </li>
        <?php if ($this->request->session()->read('Auth.User.role.level') >= 3): ?>
            <li>
                <?= $this->Form->postLink("<i class='material-icons'>layers_clear</i> Vider le cache", ['_name' => 'admin:app:cache'], ['escape' => false, 'title' => 'Vider le cache', 'target' => '_slef', 'method' => 'DELETE']) ?>
            </li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
