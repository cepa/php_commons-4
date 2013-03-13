<?php

require_once 'bootstrap.php';

use Commons\Xml\Xml;
use Commons\Xml\Writer;
use Commons\Xml\Reader;

$xml = new Xml();
$xml->johny->name = 'Johny Walker';
$xml->johny->email = 'johny@walker.com';
$xml->jack->name = 'Jack Daniels';
$xml->jack->email = 'jack@daniels.com';

$writer = new Writer();
$str = $writer->writeToString($xml);
var_dump($str);

$reader = new Reader();
$xml = $reader->readFromString($str);
var_dump($xml->toString());
