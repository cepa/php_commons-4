<?php

/**
 * =============================================================================
 * @file       Commons/Plugin/InvokerInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Plugin;

interface InvokerInterface
{
    
    /**
     * Set plugin broker.
     * @param Broker $pluginBroker
     * @return InvokerInterface
     */
    public function setPluginBroker(Broker $pluginBroker);
    
    /**
     * Get plugin broker.
     * @return Broker
     */
    public function getPluginBroker();
    
    /**
     * Invoke plugin.
     * @param string $plugin
     * @param array $args
     * @return mixed
     */
    public function __call($plugin, array $args = array());
    
}
