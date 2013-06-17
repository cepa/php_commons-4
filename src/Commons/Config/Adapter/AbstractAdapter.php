<?php

/**
 * =============================================================================
 * @file       Commons/Config/Adapter/AbstractAdapter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Config\Adapter;

use Commons\Config\Config;

abstract class AbstractAdapter implements AdapterInterface
{
    
    protected $_config;

    /**
     * Set config.
     * @see Commons\Config\Adapter\AdapterInterface::setConfig()
     */
    public function setConfig(Config $config)
    {
        $this->_config = $config;
        return $this;
    }
    
    /**
     * Get config.
     * @throws Exception
     * @return Config
     */
    public function getConfig()
    {
        if (!isset($this->_config)) {
            throw new Exception("Missing config object!");
        }
        return $this->_config;
    }
    
}
