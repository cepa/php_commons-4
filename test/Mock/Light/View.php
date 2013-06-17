<?php

/**
 * =============================================================================
 * @file       Mock/Light/View.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Mock\Light;

use Commons\Container\AssocContainer;
use Commons\Light\View\ViewInterface;

class View extends AssocContainer implements ViewInterface
{

    public function render($content = null)
    {
        return 'test';
    }
    
}
