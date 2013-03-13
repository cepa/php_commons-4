<?php

require_once 'bootstrap.php';

use Commons\KeyStore\MemcacheKeyStore;
use Commons\KeyMap\Key;
use Commons\KeyMap\Map;

// Connect to a keystore.
$keyStore = new MemcacheKeyStore();
$keyStore->connect(array('host' => 'localhost', 'port' => 11211));

// Create keymap instance and set used keystore.
$map = new Map();
$map->setKeyStore($keyStore);

// Create new keys on keymap.
$a = $map->findOrCreate('a')->setValue('this is key a')->save();
$b = $map->findOrCreate('b')->setValue('this is key b')->save();
$c = $map->findOrCreate('c')->setValue('this is key c')->save();
$d = $map->findOrCreate('d')->setValue('this is key d')->save();

// Link keys a,b,c to key x.
$x = $map->findOrCreate('x')->setValue('this is keyspace x')
    ->addLink($a->getUnique())
    ->addLink($b->getUnique())
    ->addLink($c->getUnique())
    ->save();

// Get key x from keymap.
unset($x);
$x = $map->find('x');

// Print contents of key x and all linked keys (a, b, c).
echo "{$x->getUnique()}: {$x->getValue()}\n";
foreach ($x->getLinks() as $unique) {
    $key = $map->find($unique);
    echo "   {$key->getUnique()}: {$key->getValue()}\n";    
}

// Get key x from keymap and remove it with all linked keys (a, b, c).
unset($x);
$x = $map->find('x')->delete();

// Check if all linked keys were deleted (NULL).
var_dump($map->find('x'));
var_dump($map->find('a'));
var_dump($map->find('b'));
var_dump($map->find('c'));

// Check if key d was not touched.
$key = $map->find('d');
echo "{$key->getUnique()}: {$key->getValue()}\n";
