<?php

/**
 * =============================================================================
 * @file        Mock_Custom_Autoload_Method.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

class Mock_Custom_Autoload_Method 
{

    public function __toString()
    {
        return get_class($this);
    }
    
}
