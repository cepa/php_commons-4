<?php

require_once 'bootstrap.php';

use Commons\KeyStore\RedisKeyStore;

$keyStore = new RedisKeyStore();
$keyStore->connect(array(
    'servers' => array(
        array('scheme' => 'tcp', 'host' => 'localhost', 'port' => 6379)
    )
));

$keyStore->set('a value', 123);
var_dump($keyStore->has('a value'));
var_dump($keyStore->get('a value'));

$keyStore->increment('a value');
var_dump($keyStore->get('a value'));

$keyStore->decrement('a value');
var_dump($keyStore->get('a value'));

$keyStore->remove('a value');
var_dump($keyStore->has('a value'));

$keyStore->disconnect();
