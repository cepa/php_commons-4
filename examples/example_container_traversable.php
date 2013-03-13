<?php

require_once 'bootstrap.php';

use Commons\Container\TraversableContainer;

// Simple tree.
$tree = new TraversableContainer('my tree');
$tree->jack->name = 'Jack Daniels';
$tree->jack->email = 'jack@daniels.com';
$tree->johny->name = 'Johny Walker';
$tree->johny->email = 'johny@walker.com';
var_dump($tree->toArray());

// ArrayAccess.
$tree = new TraversableContainer(); 
$tree[] = 'aaa';
$tree[] = 'bbb';
$tree[] = 'ccc';
$tree[100] = 'xxx';
var_dump($tree->toArray());

// Tree from array.
$tree = new TraversableContainer(array(
    'pinky' => array(
        'size' => 'big', 
        'iq' => 'small'
    ),
    'brain' => array(
        'size' => 'small',
        'iq' => 'big'
    )
));
var_dump($tree->toArray());
var_dump((string) $tree->pinky->iq);
var_dump((string) $tree->brain->iq);
