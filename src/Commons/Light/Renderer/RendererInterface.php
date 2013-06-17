<?php

/**
 * =============================================================================
 * @file       Commons/Light/Renderer/RendererInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\Renderer;

use Commons\Light\View\ViewInterface;

interface RendererInterface
{

    /**
     * Render a view.
     * @param ViewInterface $view
     * @return mixed
     */
    public function render(ViewInterface $view);
    
}
