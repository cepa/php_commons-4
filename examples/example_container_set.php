<?php

require_once 'bootstrap.php';

use Commons\Container\SetContainer;

$set = new SetContainer();
$set[] = 123;
$set[] = 456;
$set[] = 789;
var_dump($set->toArray());
var_dump(count($set));

$set = new SetContainer(array('xxx', 'yyy'));
foreach ($set as $index => $value) {
    var_dump("$index => $value");
}
