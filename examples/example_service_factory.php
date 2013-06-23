<?php

require_once dirname(__FILE__).'/../vendor/autoload.php';

use Commons\Service\ServiceManager;

class FooService
{
    public function foo()
    {
        return 'Hello!';
    }
}

$sm = new ServiceManager();

$sm->addFactory('Foo', function(){
    return new FooService();
});

echo $sm->getService('Foo')->foo();
