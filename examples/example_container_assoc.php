<?php

require_once 'bootstrap.php';

use Commons\Container\AssocContainer;

$assoc = new AssocContainer();
$assoc->x = 123;
$assoc->y = 456;
$assoc->z = 789;
var_dump($assoc->toArray());
var_dump(count($assoc));

$assoc = new AssocContainer(array('a' => 'xxx', 'b' => 'yyy'));
foreach ($assoc as $key => $value) {
    var_dump("$key => $value");
}
