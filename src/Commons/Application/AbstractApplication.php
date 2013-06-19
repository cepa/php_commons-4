<?php

/**
 * =============================================================================
 * @file       Commons/Application/AbstractApplication.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Application;

use Psr\Log\LoggerInterface;
use Commons\Config\ConfigAwareInterface;
use Commons\Log\Log;
use Commons\Log\LoggerAwareInterface;
use Commons\Service\ServiceManager;

abstract class AbstractApplication implements LoggerAwareInterface, ConfigAwareInterface
{

    protected $_environment;
    protected $_version;
    protected $_path;
    protected $_logger;
    protected $_config;
    protected $_serviceManager;

    /**
     * Set environment.
     * @param string $environment
     * @return AbstractApplication
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
     * Set version.
     * @param string $version
     * @return AbstractApplication
     */
    public function setVersion($version)
    {
        $this->_version = $version;
        return $this;
    }

    /**
     * Get version.
     * @return string
     */
    public function getVersion()
    {
        return $this->_version;
    }

    /**
     * Set path.
     * @param string $path
     * @return AbstractApplication
     */
    public function setPath($path)
    {
        $this->_path = $path;
        return $this;
    }

    /**
     * Get path.
     * @return string
     */
    public function getPath()
    {
        return $this->_path;
    }
    
    /**
     * Set logger.
     * @param LoggerInterface $logger
     * @return \Commons\Application\AbstractApplication
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->_logger = $logger;
        return $this;
    }
    
    /**
     * Get logger.
     * @return LoggerInterface
     */
    public function getLogger()
    {
        if (!isset($this->_logger)) {
            $this->setLogger(Log::getLogger());
        }
        return $this->_logger;
    }

    /**
     * Set config.
     * @param mixed $config
     * @return AbstractApplication
     */
    public function setConfig($config)
    {
        $this->_config = $config;
        return $this;
    }

    /**
     * Get config.
     * @return mixed
     */
    public function getConfig()
    {
        return $this->_config;
    }
    
    /**
     * Set service manager.
     * @param ServiceManager $manager
     * @return \Commons\Application\AbstractApplication
     */
    public function setServiceManager(ServiceManager $manager)
    {
        $this->_serviceManager = $manager;
        return $this;
    }
    
    /**
     * Get service manager.
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        if (!isset($this->_serviceManager)) {
            $this->setServiceManager(new ServiceManager());
        }
        return $this->_serviceManager;
    }

}
