<?php

/**
 * =============================================================================
 * @file       Commons/Light/View/Phtml/Script.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\View\Phtml;

use Commons\Buffer\OutputBuffer;
use Commons\Container\AssocContainer;
use Commons\Light\View\Template\TemplateLocator;
use Commons\Light\View\Template\TemplateLocatorAwareInterface;
use Commons\Plugin\PluginAwareInterface;
use Commons\Plugin\PluginBroker;

class Script extends AssocContainer implements TemplateLocatorAwareInterface, PluginAwareInterface
{
    
    protected $_templateLocator;
    protected $_pluginBroker;
    
    /**
     * Set template locator.
     * @see \Commons\Light\View\Template\TemplateLocatorAwareInterface::setTemplateLocator()
     */
    public function setTemplateLocator(TemplateLocator $templateLocator)
    {
        $this->_templateLocator = $templateLocator;
        return $this;
    }
    
    /**
     * Get template locator.
     * @see \Commons\Light\View\Template\TemplateLocatorAwareInterface::getTemplateLocator()
     */
    public function getTemplateLocator()
    {
        if (!isset($this->_templateLocator)) {
            $this->setTemplateLocator(new TemplateLocator());
        }
        return $this->_templateLocator;
    }
        
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
                ->addNamespace('Commons\Light\View\Phtml\Plugin')
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
    
    /**
     * Render PHP template.
     * @see \Commons\Light\View\Phtml\Script::render()
     */
    public function render($template)
    {
        $path = $this->getTemplateLocator()->locate($template.'.phtml');
        OutputBuffer::start();
        $result = @include $path;
        $content = OutputBuffer::end();
        if ($result === false) {
            throw new Exception("Cannot render script '{$template}'");
        }
        return $content;
    }
    
}
