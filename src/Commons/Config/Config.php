<?php

/**
 * =============================================================================
 * @file       Commons/Config/Config.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Config;

use Commons\Container\TraversableContainer;
use Commons\Config\Adapter\AdapterInterface;

class Config extends TraversableContainer
{
    
    protected $_adapter;
    protected $_environment;
    
    /**
     * Set environment.
     * @param string $environment
     * @return Config
     */
    public function setEnvironment($environment)
    {
        $this->_environment = $environment;
        return $this;
    }
    
    /**
     * Get environment.
     * @return string
     */
    public function getEnvironment()
    {
        return $this->_environment;
    }
    
    /**
     * Set adapter.
     * @param AdapterInterface $adapter
     * @return Config
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->_adapter = $adapter;
        return $this;
    }
    
    /**
     * Get adapter.
     * @throws Exception
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        if (!isset($this->_adapter)) {
            throw new Exception("Missing config adapter!");
        }
        return $this->_adapter;
    }
    
    /**
     * Load config.
     * @param mixed $loadable
     * @return Config
     */
    public function load($loadable)
    {
        $this->getAdapter()->setConfig($this);
        $this->getAdapter()->load($loadable);
        return $this;
    }
    
    /**
     * Load config from file.
     * @param string $filename
     * @return Config
     */
    public function loadFromFile($filename)
    {
        $this->getAdapter()->setConfig($this);
        $this->getAdapter()->loadFromFile($filename);
        return $this;
    }
    
}
