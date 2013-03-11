<?php

/**
 * =============================================================================
 * @file        Commons/Light/View/ViewInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\View;

interface ViewInterface
{
    
    /**
     * Render view.
     * @param mixed $mixed
     * @return string
     */
    public function render($mixed = null);
    
}
