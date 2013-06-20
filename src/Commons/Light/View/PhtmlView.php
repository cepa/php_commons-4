<?php

/**
 * =============================================================================
 * @file       Commons/Light/View/PhtmlView.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\View;

use Commons\Buffer\OutputBuffer;
use Commons\Container\AssocContainer;
use Commons\Light\View\Phtml\Script;
use Commons\Light\View\Template\TemplateAwareInterface;
use Commons\Light\View\Template\TemplateLocator;
use Commons\Light\View\Template\TemplateLocatorAwareInterface;

class PhtmlView extends AssocContainer implements 
        ViewInterface,
        TemplateAwareInterface, 
        TemplateLocatorAwareInterface
{

    protected $_template;
    protected $_templateLocator;

    public function setTemplate($template)
    {
        $this->_template = $template;
        return $this;
    }
    
    public function getTemplate()
    {
        return $this->_template;
    }
    
    public function setTemplateLocator(TemplateLocator $templateLocator)
    {
        $this->_templateLocator = $templateLocator;
        return $this;
    }
    
    public function getTemplateLocator()
    {
        if (!isset($this->_templateLocator)) {
            $this->setTemplateLocator(new TemplateLocator());
        }
        return $this->_templateLocator;
    }
    
    /**
     * Render script to html.
     * @return string
     */
    public function render($content = null)
    {
        $template = $this->getTemplate();
        if (empty($template)) {
            return $content;
        }
        
        $script = new Script($this->toArray());
        $script->content = $content;
        return $script
            ->setTemplateLocator($this->getTemplateLocator())
            ->render($template);
    }
    
}
