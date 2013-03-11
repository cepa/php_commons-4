<?php

/**
 * =============================================================================
 * @file        Commons/Light/View/Renderer/RendererInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\View\Renderer;

use Commons\Light\View\ViewInterface;

interface RendererInterface
{

    /**
     * Set view.
     * @param ViewInterface $view
     * @return RendererInterface
     */
    public function setView(ViewInterface $view);
    
    /**
     * Get view.
     * @return \Commons\Light\View\ViewInterface
     */
    public function getView();
    
    /**
     * Render.
     * @param mixed $mixed
     * @return string
     */
    public function render($mixed = null);
    
}
