<?php

/**
 * =============================================================================
 * @file       Commons/Config/JsonConfig.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Config;

use Commons\Config\Adapter\JsonAdapter;

class JsonConfig extends Config
{
    
    public function __construct($mixed = null)
    {
        parent::__construct($mixed);
        $this->setAdapter(new JsonAdapter());
    }
    
}

