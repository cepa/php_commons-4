<?php

/**
 * =============================================================================
 * @file       Commons/Event/EventDispatcherInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Event;

interface EventDispatcherInterface
{

    /**
     * Bind callback by event classname.
     * @param string $classname
     * @param callable $callable
     * @return EventDispatcherInterface
     */
    public function bind($classname, $callable);

    /**
     * Raise event.
     * @param object $event
     * @return EventDispatcherInterface
     */
    public function raise($event);

    /**
     * Clear bindings by event classname.
     * @param string $classname
     * @return EventDispatcherInterface
     */
    public function clear($classname);

}
