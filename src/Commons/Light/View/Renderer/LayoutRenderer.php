<?php

/**
 * =============================================================================
 * @file        Commons/Light/View/Renderer/LayoutRenderer.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\View\Renderer;

use Commons\Light\View\ScriptView;
use Commons\Light\View\ViewInterface;

class LayoutRenderer implements RendererInterface
{
    
    protected $_view;
    protected $_layoutPath;
    protected $_isEnabled = true;
    
    /**
     * Set view.
     * @see \Commons\Light\View\Renderer\RendererInterface::setView()
     */
    public function setView(ViewInterface $view)
    {
        $this->_view = $view;
        return $this;
    }
    
    /**
     * Get view.
     * @see \Commons\Light\View\Renderer\RendererInterface::getView()
     */
    public function getView()
    {
        if (!isset($this->_view)) {
            $this->_view = new ScriptView();
        }
        return $this->_view;
    }
    
    /**
     * Set layout path.
     * @param string $path
     * @return \Commons\Light\View\Renderer\LayoutRenderer
     */
    public function setLayoutPath($path)
    {
        $this->_layoutPath = $path;
        return $this;
    }
    
    /**
     * Get layout path.
     * @return string
     */
    public function getLayoutPath()
    {
        return $this->_layoutPath;
    }
    
    /**
     * Set enabled flag.
     * @param bboolean $bool
     * @return \Commons\Light\View\Renderer\LayoutRenderer
     */
    public function setEnabled($bool)
    {
        $this->_isEnabled = $bool;
        return $this;
    }
    
    /**
     * Get enbaled flag.
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->_isEnabled;
    }
    
    /**
     * Render layout.
     * @see \Commons\Light\View\Renderer\RendererInterface::render()
     */
    public function render($content = null)
    {
        if (!isset($content)) {
            $content = $this->getView()->render();
        }
        if (!$this->isEnabled() || !($this->getView() instanceof ScriptView)) {
            return $content;
        }
        $this->getView()->content = $content;
        return $this->getView()->render($this->getLayoutPath());
    }
    
}
