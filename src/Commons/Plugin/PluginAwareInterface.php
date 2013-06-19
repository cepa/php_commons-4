<?php

/**
 * =============================================================================
 * @file       Commons/Plugin/PluginAwareInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Plugin;

interface PluginAwareInterface
{
    
    /**
     * Set plugin broker.
     * @param Broker $pluginBroker
     * @return PluginAwareInterface
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
