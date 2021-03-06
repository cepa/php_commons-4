<?php

/**
 * =============================================================================
 * @file       Mock/Plugin/Invoker.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Mock\Plugin;

use Commons\Plugin\PluginBroker;
use Commons\Plugin\PluginAwareInterface;

class Invoker implements PluginAwareInterface
{
    
    protected $_pluginBroker;

    public function setPluginBroker(PluginBroker $pluginBroker)
    {
        $this->_pluginBroker = $pluginBroker;
        return $this;
    }
    
    public function getPluginBroker()
    {
        if (!isset($this->_pluginBroker)) {
            $broker = new PluginBroker();
            $broker->addNamespace('Mock\\Plugin');
            $this->setPluginBroker($broker);
        }
        return $this->_pluginBroker;
    }
    
    public function __call($plugin, array $args = array())
    {
        return $this->getPluginBroker()->invoke($this, $plugin, $args);
    }
    
    
}
