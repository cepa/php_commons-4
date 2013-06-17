<?php

/**
 * =============================================================================
 * @file       Commons/Event/Dispatcher.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Event;

use Commons\Callback\Callback;

class Dispatcher
{
    
    protected $_bindings = array();
    
    public function __construct() {}
    
    /**
     * Bind a callback to an event.
     * @param Commons\Event\Event $event
     * @param Commons\Callback\Callback $callback
     * @return Commons\Event\Dispatcher
     */
    public function bind(Event $event, Callback $callback)
    {
        $this->_bindings[$event->getName()][] = $callback;
        return $this;
    }
    
    /**
     * Raise an event.
     * @param Commons\Event\Event $event
     * @return Commons\Event\Dispatcher
     */
    public function raise(Event $event)
    {
        $event->preRaise();
        $name = $event->getName();
        if (isset($this->_bindings[$name])) {
            foreach ($this->_bindings[$name] as $callback) {
                $callback->call($event);
            }
        }
        $event->postRaise();
        return $this;
    }
    
    /**
     * Clear event bindings.
     * @param Commons\Event\Event $event
     * @return Commons\Event\Dispatcher
     */
    public function clear(Event $event)
    {
        unset($this->_bindings[$event->getName()]);
        return $this;
    }
    
}
