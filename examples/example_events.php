<?php

require_once 'bootstrap.php';

use Commons\Event\Event;
use Commons\Event\EventDispatcher;

class MyEvent extends Event
{

}

$dispatcher = new EventDispatcher();
$dispatcher->bind('MyEvent', function ($event) {
    echo "{$event->state}\n";
});

$event = new MyEvent();
$event->state = 'hello';

$dispatcher->raise($event);
