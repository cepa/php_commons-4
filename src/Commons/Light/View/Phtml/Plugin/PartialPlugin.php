<?php

/**
 * =============================================================================
 * @file       Commons/Light/View/Phtml/Plugin/PartialPlugin.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\View\Phtml\Plugin;

use Commons\Light\View\Phtml\Script;
use Commons\Light\View\Template\TemplateLocatorAwareInterface;
use Commons\Plugin\AbstractPlugin;

class PartialPlugin extends AbstractPlugin
{
    
    /**
     * Render partial.
     * @param string $template
     * @param array $context
     * @return string
     */
    public function partial($template, array $context = array())
    {
        $script = new Script($context);
        $script->setPluginBroker($this->getInvoker()->getPluginBroker());
        if ($this->getInvoker() instanceof TemplateLocatorAwareInterface) {
            $script->setTemplateLocator($this->getInvoker()->getTemplateLocator());
        }
        return $script->render($template);
    }
    
}

