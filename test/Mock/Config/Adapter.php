<?php

/**
 * =============================================================================
 * @file        Mock/Config/Adapter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Mock\Config;

use Commons\Config\Adapter\AbstractAdapter;

class Adapter extends AbstractAdapter
{
    
    public function load($loadable)
    {
        $this->getConfig()->loadable = $loadable;
    }
    
    public function loadFromFile($filename)
    {
        $this->getConfig()->filename = $filename;
    }
   
}
