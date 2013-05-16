<?php

require_once '../bootstrap.php';

use Commons\Light\View\ScriptView;
use Commons\Moo\Moo;

$moo = new Moo();
$moo

    ->init(function(Moo $moo){
        $moo->getRenderer()->getLayout()->setScriptPath('templates/layout.phtml');
    })
    
    ->get('/', function(Moo $moo){
        $view = new ScriptView();
        $view->setScriptPath('templates/index.phtml');
        $view->message = 'Hello World!';
        return $view;
    })
    
    ->moo();
