<?php

/**
 * =============================================================================
 * @file       Commons/Template/AbstractTemplate.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Template;

use Commons\Container\AssocContainer;
use Commons\Plugin\PluginAwareInterface;
use Commons\Plugin\Broker as PluginBroker;

abstract class AbstractTemplate extends AssocContainer implements PluginAwareInterface
{
    
    protected $_pluginBroker;
    
    /**
     * Render template script.
     * @param string $template
     * @return string
     */
    abstract public function render($template);
    
    /**
     * Set plugin broker.
     * @see \Commons\Plugin\PluginAwareInterface::setPluginBroker()
     */
    public function setPluginBroker(PluginBroker $pluginBroker)
    {
        $this->_pluginBroker = $pluginBroker;
        return $this;
    }
    
    /**
     * Get plugin broker.
     * @see \Commons\Plugin\PluginAwareInterface::getPluginBroker()
     */
    public function getPluginBroker()
    {
        if (!isset($this->_pluginBroker)) {
            $broker = new PluginBroker();
            $broker
                ->addNamespace('Commons\Template\Plugin')
                ->addNamespace('Commons\Http\Plugin');
            $this->setPluginBroker($broker);
        }
        return $this->_pluginBroker;
    }
    
    /**
     * Invoke plugin.
     * @see \Commons\Plugin\PluginAwareInterface::__call()
     */
    public function __call($plugin, array $args = array())
    {
        return $this->getPluginBroker()->invoke($this, $plugin, $args);
    }
    
}
