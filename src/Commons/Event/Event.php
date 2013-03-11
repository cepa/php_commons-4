<?php

/**
 * =============================================================================
 * @file        Commons/Event/Event.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Event;

use Commons\Callback\Callback;
use Commons\Container\AssocContainer;
use Commons\Exception\InvalidArgumentException;

class Event extends AssocContainer
{

    protected static $_dispatcher = null;
    
    protected $_name;
    
    /**
     * Create an event.
     * @param string $name
     * @param array $params
     * @throws Commons\Exception\InvalidArgumentException
     */
    public function __construct($name, array $params = array())
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException();
        }
        $this->_name = $name;
        $this->setAll($params);
    }
    
    /**
     * Get the event name.
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }
    
    public function __toString()
    {
        return (string) $this->_name;
    }
    
    /**
     * Pre raise hook.
     */
    public function preRaise()
    {
        
    }
    
    /**
     * Post raise hook.
     */
    public function postRaise()
    {
        
    }
    
    /**
     * Set global dispatcher.
     * @param Commons\Event\Dispatcher $dispatcher
     */
    public static function setDispatcher(Dispatcher $dispatcher)
    {
        self::$_dispatcher = $dispatcher;
    }
    
    /**
     * Get global dispatcher.
     * @return Commons\Event\Dispatcher
     */
    public static function getDispatcher()
    {
        if (!isset(self::$_dispatcher)) {
            self::setDispatcher(new Dispatcher());
        }
        return self::$_dispatcher;
    }
    
    /**
     * Bind a callback to an event.
     * @param Commons\Event\Event|string $event
     * @param Commons\Callback\Callback|string|array $callback
     */
    public static function bind($event, $callback)
    {
        self::getDispatcher()->bind(self::_prepareEvent($event), self::_prepareCallback($callback));
    }
    
    /**
     * Raise an event.
     * @param Commons\Event\Event|string $event
     * @param array $params
     */
    public static function raise($event, array $params = null)
    {
        $event = self::_prepareEvent($event);
        if (isset($params)) {
            $event->setAll($params);
        }
        self::getDispatcher()->raise($event);
    }
    
    /**
     * Clear event bindings.
     * @param Commons\Event\Event|string $event
     */
    public static function clear($event)
    {
        self::getDispatcher()->clear(self::_prepareEvent($event));
    }
    
    protected static function _prepareEvent($event)
    {
        if (!($event instanceof Event)) {
            $event = new Event($event);
        }
        return $event;
    }
    
    protected static function _prepareCallback($callback)
    {
        if (!($callback instanceof Callback)) {
            $callback = new Callback($callback);
        }
        return $callback;
    }
    
}
