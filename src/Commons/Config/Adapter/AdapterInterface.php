<?php

/**
 * =============================================================================
 * @file        Commons/Config/Adapter/AdapterInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Config\Adapter;

use Commons\Config\Config;

interface AdapterInterface
{

    public function setConfig(Config $config);
    
    public function load($loadable);
    
    public function loadFromFile($filename);
    
}
