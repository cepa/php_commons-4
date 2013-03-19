<?php

/**
 * =============================================================================
 * @file        Commons/Config/Adapter/AbstractAdapter.php
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
use Commons\Exception\NotFoundException;

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
     * @throws NotFoundException
     * @return Config
     */
    public function getConfig()
    {
        if (!isset($this->_config)) {
            throw new NotFoundException("Missing config object!");
        }
        return $this->_config;
    }
    
}
