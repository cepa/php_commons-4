<?php

/**
 * =============================================================================
 * @file       Mock/Plugin/FooPlugin.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Mock\Plugin;

use Commons\Plugin\AbstractPlugin;

class FooPlugin extends AbstractPlugin
{
    
    public function foo($str)
    {
        return $str;
    }
    
}
