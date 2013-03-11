<?php

/**
 * =============================================================================
 * @file        Mock/OldAutoloadMethod.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

class Mock_OldAutoloadMethod 
{
    
    public function __toString()
    {
        return get_class($this);
    }
    
}
