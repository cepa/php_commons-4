<?php

/**
 * =============================================================================
 * @file        Commons/Light/View/TemplateView.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\View;

use Commons\Buffer\OutputBuffer;
use Commons\Container\AssocContainer;
use Commons\Template\PhpTemplate;

class TemplateView extends AssocContainer implements ViewInterface 
{

    protected $_templatePath;
    protected $_templateClass = '\Commons\Template\PhpTemplate';
    
    /**
     * Set template path.
     * @param string $templatePath
     * @return \Commons\Light\View\TemplateView
     */
    public function setTemplatePath($templatePath)
    {
        $this->_templatePath = $templatePath;
        return $this;
    }
    
    /**
     * Get template path.
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->_templatePath;
    }

    /**
     * Set template class.
     * @param string $templateClass
     * @return \Commons\Light\View\TemplateView
     */
    public function setTemplateClass($templateClass)
    {
        $this->_templateClass = $templateClass;
        return $this;
    }
    
    /**
     * Get template class.
     * @return string
     */
    public function getTemplateClass()
    {
        return $this->_templateClass;
    }
    
    /**
     * Render script to html.
     * @return string
     */
    public function render($content = null)
    {
        $path = $this->getTemplatePath();
        if (empty($path)) {
            return $content;
        }
        
        $class = $this->getTemplateClass();
        $template = new $class($this->toArray());
        $template->content = $content;
        return $template->render($path);
    }
    
}
