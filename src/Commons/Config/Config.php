<?php

/**
 * =============================================================================
 * @file        Commons/Config/Config.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Config;

use Commons\Container\TraversableContainer;
use Commons\Config\Adapter\AdapterInterface;
use Commons\Exception\NotFoundException;

class Config extends TraversableContainer
{
    
    protected $_adapter;
    protected $_environment;
    
    /**
     * Prepare config.
     * @param string $environment
     * @param Commons\Config\Adapter\AdapterInterface $adapter
     */
    public function __construct($environment = null, AdapterInterface $adapter = null)
    {
        parent::__construct();
        $this->_environment = $environment;
        $this->_adapter = $adapter;
    }
    
    /**
     * Set environment.
     * @param string $environment
     * @return Commons\Config\Config
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
     * @param Commons\Config\Adapter\AdapterInterface $adapter
     * @return Commons\Config\Config
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->_adapter = $adapter;
        return $this;
    }
    
    /**
     * Get adapter.
     * @throws Commons\Exception\NotFoundException
     * @return Commons\Config\Adapter\AdapterInterface
     */
    public function getAdapter()
    {
        if (!isset($this->_adapter)) {
            throw new NotFoundException("Missing config adapter!");
        }
        return $this->_adapter;
    }
    
    /**
     * Load config.
     * @param mixed $loadable
     * @return Commons\Config\Config
     */
    public function load($loadable)
    {
        $this->_adapter->setConfig($this);
        $this->_adapter->load($loadable);
        return $this;
    }
    
    /**
     * Load config from file.
     * @param string $filename
     * @return Commons\Config\Config
     */
    public function loadFromFile($filename)
    {
        $this->_adapter->setConfig($this);
        $this->_adapter->loadFromFile($filename);
        return $this;
    }
    
}
