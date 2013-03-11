<?php

/**
 * =============================================================================
 * @file        Commons/Config/Xml.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Config;

use Commons\Config\Adapter\XmlAdapter;

class XmlConfig extends Config
{
    
    public function __construct($environment = null)
    {
        parent::__construct($environment, new XmlAdapter());
    }
    
}

