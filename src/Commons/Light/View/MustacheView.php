<?php

/**
 * =============================================================================
 * @file       Commons/Light/View/MustacheView.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\View;

use Mustache_Engine;
use Commons\Container\AssocContainer;
use Commons\Light\View\Template\TemplateAwareInterface;

class MustacheView extends AssocContainer implements ViewInterface, TemplateAwareInterface
{
    
    protected $_engine;
    protected $_template;
    
    /**
     * Set mustache engine.
     * @param Mustache_Engine $engine
     * @return \Commons\Light\View\MustacheView
     */
    public function setEngine(Mustache_Engine $engine)
    {
        $this->_engine = $engine;
        return $this;
    }
    
    /**
     * Get mustache engine.
     * @return Mustache_Engine
     */
    public function getEngine()
    {
        if (!isset($this->_engine)) {
            $this->setEngine(new Mustache_Engine());
        }
        return $this->_engine;
    }
    
    /**
     * Set template.
     * @param string $template
     * @return \Commons\Light\View\MustacheView
     */
    public function setTemplate($template)
    {
        $this->_template = $template;
        return $this;
    }
    
    /**
     * Get template.
     * @return string
     */
    public function getTemplate()
    {
        return $this->_template;
    }

    /**
     * Render.
     * @see \Commons\Light\View\ViewInterface::render()
     */
    public function render($content = null)
    {
        $context = array_merge(array('content' => $content), $this->toArray());
        return $this->getEngine()->loadTemplate($this->getTemplate())->render($context);
    }
    
}
