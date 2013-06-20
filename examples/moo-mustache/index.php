<?php

require_once '../bootstrap.php';

use \Mustache_Engine;
use \Mustache_Loader_FilesystemLoader;
use Commons\Light\View\MustacheView;
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
        $view = new MustacheView();
        $view
            ->setEngine($moo->getMustacheEngine())
            ->setTemplate($template);
        return $view;
    })
    
    ->closure('getMustacheEngine', function(Moo $moo){
        static $engine;
        if (!isset($engine)) {
            $engine = new Mustache_Engine(array(
                'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/templates/'),
                'helpers' => array(
                    'assetUrl' => function($asset) use($moo) {
                        return $moo->assetUrl($asset);
                    }
                )
            ));
        }
        return $engine;
    })
    
    ->moo();
