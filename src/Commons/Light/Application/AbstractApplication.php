<?php

/**
 * =============================================================================
 * @file        Commons/Light/Application/AbstractApplication.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\Application;

abstract class AbstractApplication
{

    protected $_environment = 'development';
    protected $_version;
    protected $_path;
    protected $_config;
    protected $_logger;
    protected $_modules = array();
    protected $_properties = array();

    /**
     * Set environment.
     * @param string $environment
     * @return instanceof Application\AbstractApplication
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
     * @return instanceof Application\AbstractApplication
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
     * @return instanceof Application\AbstractApplication
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
     * Set config.
     * @param mixed $config
     * @return instanceof Application\AbstractApplication
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
     * Set logger.
     * @param mixed $logger
     * @return \Commons\Light\Application\AbstractApplication
     */
    public function setLogger($logger)
    {
        $this->_logger = $logger;
        return $this;
    }
    
    /**
     * Get logger.
     * @return Logger
     */
    public function getLogger()
    {
        return $this->_logger;
    }

    /**
     * Set modules.
     * @param array $modules
     * @return instanceof Application\AbstractApplication
     */
    public function setModules(array $modules)
    {
        $this->_modules = $modules;
        return $this;
    }

    /**
     * Get modules.
     * @return array
     */
    public function getModules()
    {
        return $this->_modules;
    }

    /**
     * Clear modules.
     * @return instanceof Application\AbstractApplication
     */
    public function clearModules()
    {
        $this->_modules = array();
        return $this;
    }

    /**
     * Add module.
     * @param string $name
     * @param mixed $value
     * @return instanceof Application\AbstractApplication
     */
    public function addModule($name, $value = null)
    {
        if (!isset($value)) {
            $value = $name;
        }
        $this->_modules[(string) $name] = $value;
        return $this;
    }

    /**
     * Get module.
     * @param string $name
     * @throws \Commons\Ligh\Application\Exception
     * @return mixed
     */
    public function getModule($name)
    {
        if (!isset($this->_modules[(string) $name])) {
            throw new Exception("Module '{$name}' has not been found!");
        }
        return $this->_modules[(string) $name];
    }

    /**
     * Check if has a module.
     * @param string $module
     * @return boolean
     */
    public function hasModule($name)
    {
        return isset($this->_modules[(string) $name]);
    }

    /**
     * Remove module.
     * @param string $name
     * @return instanceof Application\AbstractApplication
     */
    public function removeModule($name)
    {
        unset($this->_modules[(string) $name]);
        return $this;
    }

    /**
     * Set property.
     * @param string $name
     * @param mixed $value
     * @return instanceof Application\AbstractApplication
     */
    public function setProperty($name, $value)
    {
        $this->_properties[$name] = $value;
        return $this;
    }

    /**
     * Get property.
     * @param string $name
     * @param midex $defaultValue
     * @return mixed
     */
    public function getProperty($name, $defaultValue = null)
    {
        return (isset($this->_properties[$name]) ? $this->_properties[$name] : $defaultValue);
    }

    /**
     * Has property.
     * @param string $name
     * @return boolean
     */
    public function hasProperty($name)
    {
        return isset($this->_properties[$name]);
    }

    /**
     * Remove property.
     * @param string $name
     * @return instanceof Application\AbstractApplication
     */
    public function removeProperty($name)
    {
        unset($this->_properties[$name]);
        return $this;
    }

    /**
     * Set properties.
     * @param array $properties
     * @return instanceof Application\AbstractApplication
     */
    public function setProperties(array $properties)
    {
        $this->_properties = $properties;
        return $this;
    }

    /**
     * Get properties.
     * @return array
     */
    public function getProperties()
    {
        return $this->_properties;
    }

    /**
     * Clear properties.
     * @return instanceof Application\AbstractApplication
     */
    public function clearProperties()
    {
        $this->_properties = array();
        return $this;
    }

}
