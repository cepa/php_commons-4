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
        $view = $moo->createView('templates/index.phtml');
        $view->message = 'Hello World!';
        return $view;
    })
    
    ->get('/about', function(Moo $moo){
        return $moo->createView('templates/about.phtml');
    })
    
    ->plugin('createView', function(Moo $moo, $path){
        $view = new TemplateView();
        $view->setTemplatePath($path);
        return $view;
    })
    
    ->moo();
