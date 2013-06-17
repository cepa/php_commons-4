<?php

/**
 * =============================================================================
 * @file       Mock/OldAutoloadMethod.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

class Mock_OldAutoloadMethod 
{
    
    public function __toString()
    {
        return get_class($this);
    }
    
}
