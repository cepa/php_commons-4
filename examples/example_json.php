<?php

require_once 'bootstrap.php';

use Commons\Json\Encoder;
use Commons\Json\Decoder;

$encoder = new Encoder();
$json = $encoder->encode(array(
    'jack' => array(
        'name' => 'Jack Daniels',
        'age' => '15'
    ),
    'johny' => array(
        'name' => 'Johny Walker',
        'age' => 18
    )
));
var_dump($json);

$decoder = new Decoder();
$array = $decoder->decode($json);
var_dump($array);
