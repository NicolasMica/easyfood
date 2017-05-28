<?php
    $this->assign('title', "Découvrez nos plats");

    $params = json_encode([
        'token' => $this->request->getParam('_csrfToken'),
        'user' => $this->request->session()->read('Auth.User')
    ]);

    $this->Html->scriptStart(['block' => true]);
            echo "window.App = $params;";
    $this->Html->scriptEnd();

    $this->Html->script($this->Asset->path('/js/dishes.js'), ['block' => true]) ;
?>

<div id="app"></div>
