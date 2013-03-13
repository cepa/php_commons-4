<?php

require_once 'bootstrap.php';

use Commons\Event\Event;

class EventListener 
{
    
    public function onEvent(Event $e)
    {
        echo "event {$e->getName()}\n";
        foreach ($e as $key => $value) {
            echo "   {$key} = {$value}\n";
        } 
    }
    
}

Event::bind('first event', array(new EventListener(), 'onEvent'));
Event::bind('second event', array(new EventListener(), 'onEvent'));

Event::raise('first event', array('a' => 123, 'b' => 456));
Event::raise('second event', array('x' => 666, 'y' => 999));
