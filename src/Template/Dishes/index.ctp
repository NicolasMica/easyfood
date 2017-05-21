<?php
    $this->assign('title', "Découvrez nos plats");

    $this->Html->scriptStart(['block' => true]);
            echo 'window.App = ' . json_encode(['token' => $this->request->getParam('_csrfToken')]) . ';';
    $this->Html->scriptEnd();

    $this->Html->script($this->Asset->path('/js/dishes.js'), ['block' => true]) ;
?>

<div id="app"></div>
