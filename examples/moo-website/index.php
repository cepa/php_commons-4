<?php

require_once '../bootstrap.php';

use Commons\Light\View\TemplateView;
use Commons\Moo\Moo;

$moo = new Moo();
$moo

    ->init(function(Moo $moo){
        $moo->getRenderer()->getLayout()->setTemplatePath('templates/layout.phtml');
    })
    
    ->get('/', function(Moo $moo){
        $view = new TemplateView();
        $view->setTemplatePath('templates/index.phtml');
        $view->message = 'Hello World!';
        return $view;
    })
    
    ->moo();
