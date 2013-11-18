<?php

/**
 * =============================================================================
 * @file       Commons/Event/EventDispatcher.php
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

class EventDispatcher implements EventDispatcherInterface
{

    protected $_bindings = array();

    public function bind($classname, $callable)
    {
        if (!($callable instanceof Callback)) {
            $callable = new Callback($callable);
        }
        $this->_bindings[$this->_classname($classname)][] = $callable;
        return $this;
    }

    public function raise($event)
    {
        if (is_object($event)) {
            $classname = $this->_classname($event);
            if (isset($this->_bindings[$classname])) {
                foreach ($this->_bindings[$classname] as $callable) {
                    $callable->call($event);
                }
            }
        }
        return $this;
    }

    public function clear($classname)
    {
        $this->_bindings[$this->_classname($classname)] = array();
        return $this;
    }

    protected function _classname($classname)
    {
        if (is_object($classname)) {
            $classname = get_class($classname);
        }
        return trim((string) $classname, '\\');
    }

}
