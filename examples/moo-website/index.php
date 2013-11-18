<?php

require_once '../bootstrap.php';

use Commons\Light\View\PhtmlView;
use Commons\Moo\Moo;

$moo = new Moo();
$moo

    ->init(function(Moo $moo){
        $moo->getRenderer()->setLayout($moo->createView('layout'));
    })

    ->get('/', function(Moo $moo){
        $view = $moo->createView('index');
        $view->message = 'Hello World!';
        return $view;
    })

    ->get('/about', function(Moo $moo){
        return $moo->createView('about');
    })

    ->closure('createView', function(Moo $moo, $template){
        $view = new PhtmlView();
        $view->setTemplate($template);
        $view->getTemplateLocator()->addLocation(dirname(__FILE__).'/templates');
        return $view;
    })

    ->moo()
    ->send();
