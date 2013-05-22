<?php

/**
 * =============================================================================
 * @file        Commons/Template/AbstractTemplate.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Template;

use Commons\Container\AssocContainer;
use Commons\Plugin\InvokerInterface as PluginInvokerInterface;
use Commons\Plugin\Broker as PluginBroker;

abstract class AbstractTemplate extends AssocContainer implements PluginInvokerInterface
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
     * @see \Commons\Plugin\ExtendableInterface::setPluginBroker()
     */
    public function setPluginBroker(PluginBroker $pluginBroker)
    {
        $this->_pluginBroker = $pluginBroker;
        return $this;
    }
    
    /**
     * Get plugin broker.
     * @see \Commons\Plugin\ExtendableInterface::getPluginBroker()
     */
    public function getPluginBroker()
    {
        if (!isset($this->_pluginBroker)) {
            $broker = new PluginBroker();
            $broker->addNamespace('\\Commons\\Template\\Plugin');
            $this->setPluginBroker($broker);
        }
        return $this->_pluginBroker;
    }
    
    /**
     * Invoke plugin.
     * @see \Commons\Plugin\ExtendableInterface::__call()
     */
    public function __call($plugin, array $args = array())
    {
        return $this->getPluginBroker()->invoke($this, $plugin, $args);
    }
    
}
