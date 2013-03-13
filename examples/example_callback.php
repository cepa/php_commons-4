<?php

require_once 'bootstrap.php';

use Commons\Callback\Callback;

class MyClass
{
    
    public function method()
    {
        echo "Hello world!\n";
    }
    
}

$callback = new Callback(new MyClass, 'method');
$callback->call();

