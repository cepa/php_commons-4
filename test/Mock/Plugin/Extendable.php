<?php

/**
 * =============================================================================
 * @file        Mock/Plugin/Extendable.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Mock\Plugin;

use Commons\Plugin\Broker;
use Commons\Plugin\ExtendableInterface;

class Extendable implements ExtendableInterface
{
    
    protected $_pluginBroker;

    public function setPluginBroker(Broker $pluginBroker)
    {
        $this->_pluginBroker = $pluginBroker;
        return $this;
    }
    
    public function getPluginBroker()
    {
        if (!isset($this->_pluginBroker)) {
            $broker = new Broker();
            $broker->addNamespace('Mock\\Plugin');
            $this->setPluginBroker($broker);
        }
        return $this->_pluginBroker;
    }
    
    public function __call($plugin, array $args = array())
    {
        return $this->getPluginBroker()->invoke($plugin, $this, $args);
    }
    
    
}
