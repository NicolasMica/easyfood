<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;

/**
 * Application View
 *
 * Your application’s default view class
 *
 * @link http://book.cakephp.org/3.0/en/views.html#the-app-view
 */
class AppView extends View
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadHelper('Asset');

        $this->Form->setTemplates([
            'input' => '<input type="{{type}}" name="{{name}}" {{attrs}} class="validate" />',
            'inputContainer' => '{{content}}',
            'error' => '<span class="input-help">{{content}}</span>',
            'inputContainerError' => '{{content}}{{error}}',
        ]);

        $this->Paginator->setTemplates([
            'nextActive' => '<li class="waves-effect"><a rel="next" href="{{url}}">{{text}}</a></li>',
            'nextDisabled' => '<li class="disabled"><a href="" onclick="return false;">{{text}}</a></li>',
            'prevActive' => '<li class="waves-effect"><a rel="prev" href="{{url}}">{{text}}</a></li>',
            'prevDisabled' => '<li class="disabled"><a href="" onclick="return false;">{{text}}</a></li>',
            'number' => '<li class="waves-effect"><a href="{{url}}">{{text}}</a></li>',
            'current' => '<li class="active deep-purple lighten-1"><a href="">{{text}}</a></li>'
        ]);
    }
}
