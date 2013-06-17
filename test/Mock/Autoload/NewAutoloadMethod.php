<?php

/**
 * =============================================================================
 * @file       Mock/Autoload/NewAutoloadMethod.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Mock\Autoload;

class NewAutoloadMethod 
{
    
    public function __toString()
    {
        return get_class($this);
    }
    
}
