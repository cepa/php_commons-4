<?php

/**
 * =============================================================================
 * @file        Mock/Light/View.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Mock\Light;

use Commons\Light\View\ViewInterface;

class View implements ViewInterface
{

    public function render($mixed = null)
    {
        return $mixed;
    }
    
}
