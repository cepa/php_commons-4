<?php

/**
 * =============================================================================
 * @file        Commons/Light/Renderer/LayoutRenderer.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\Renderer;

use Commons\Container\AssocContainer;
use Commons\Light\View\ScriptView;
use Commons\Light\View\ViewInterface;

class LayoutRenderer implements RendererInterface
{
    
    protected $_layout;
    protected $_isLayoutEnabled = true;
    protected $_isViewEnabled = true;
    
    /**
     * Set layout.
     * @param ViewInterface $layout
     * @return \Commons\Light\Renderer\LayoutRenderer
     */
    public function setLayout(ViewInterface $layout)
    {
        $this->_layout = $layout;
        return $this;
    }
    
    /**
     * Get layout.
     * @return ViewInterface
     */
    public function getLayout()
    {
        if (!isset($this->_layout)) {
            $this->setLayout(new ScriptView());
        }
        return $this->_layout;
    }
    
    /**
     * Enable layout.
     * @param string $bool
     * @return \Commons\Light\Renderer\LayoutRenderer
     */
    public function enableLayout($bool = true)
    {
        $this->_isLayoutEnabled = $bool;
        return $this;
    }
    
    /**
     * Is layout enabled?
     * @return boolean
     */
    public function isLayoutEnabled()
    {
        return $this->_isLayoutEnabled;
    }
    
    /**
     * Enable view.
     * @param string $bool
     * @return \Commons\Light\Renderer\LayoutRenderer
     */
    public function enableView($bool = true)
    {
        $this->_isViewEnabled = $bool;
        return $this;
    }
    
    /**
     * Is view enabled?
     * @return boolean
     */
    public function isViewEnabled()
    {
        return $this->_isViewEnabled;
    }
    
    /**
     * Render.
     * @see \Commons\Light\Renderer\RendererInterface::render()
     */
    public function render(ViewInterface $view)
    {
        if ($this->isLayoutEnabled() && $this->isViewEnabled()) {
            return $this->getLayout()->render($view->render());
        
        } else if ($this->isLayoutEnabled()) {
            return $this->getLayout()->render();
        
        } else if ($this->isViewEnabled()) {
            return $view->render();
        }
    }
    
}
