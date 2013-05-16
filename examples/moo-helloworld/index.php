<?php

require_once '../bootstrap.php';

use Commons\Moo\Moo;

$moo = new Moo();
$moo

    ->init(function($moo){
        var_dump('init');
    })
    
    ->get('/', function($moo){
        var_dump('index');
    })
    
    ->get('/foo/(.*)/(.*)', function($moo, $a, $b){
        var_dump($a);
        var_dump($b);
    })
    
    ->moo();
