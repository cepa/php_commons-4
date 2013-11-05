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
use Commons\Service\ServiceManagerInterface;
use Commons\Service\ServiceManagerAwareInterface;
use Commons\Utils\StringUtils;

abstract class AbstractApplication implements ServiceManagerAwareInterface
{

    protected $_environment;
    protected $_version;
    protected $_path;
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
     * Set service manager.
     * @param ServiceManagerInterface $manager
     * @return \Commons\Application\AbstractApplication
     */
    public function setServiceManager(ServiceManagerInterface $manager)
    {
        $this->_serviceManager = $manager;
        return $this;
    }
    
    /**
     * Get service manager.
     * @return ServiceManagerInterface
     */
    public function getServiceManager()
    {
        if (!isset($this->_serviceManager)) {
            $this->setServiceManager(new ServiceManager());
        }
        return $this->_serviceManager;
    }
    
    /**
     * Init application.
     * Run all init* methods.
     * @return \Commons\Application\AbstractApplication
     */
    public function init()
    {
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getMethods() as $method) {
            if ($method->getName() != 'init' && StringUtils::startsWith($method->getName(), 'init')) {
                $method->invoke($this);
            }
        }
        return $this;
    }

}
