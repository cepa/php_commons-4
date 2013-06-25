<?php

/**
 * =============================================================================
 * @file       Commons/Service/ServiceManager.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Service;

class ServiceManager implements ServiceManagerInterface
{

    protected $_factories = array();
    protected $_services = array();
    
    /**
     * Add a service factory.
     * @param string $name
     * @param string|callable $factory
     * @return ServiceManager
    */
    public function addFactory($name, $factory)
    {
        $this->_factories[$name] = $factory;
        return $this;
    }
    
    /**
     * Has factory?
     * @param string $name
     * @return boolean
     */
    public function hasFactory($name)
    {
        return isset($this->_factories[$name]);
    }
    
    public function getFactory($name)
    {
        if (!$this->hasFactory($name)) {
            throw new Exception("There is no factory to create service {$name}");
        }
        return $this->_factories[$name];
    }
    
    /**
     * Remove factory.
     * @param string $name
     * @return ServiceManager
     */
    public function removeFactory($name)
    {
        unset($this->_factories[$name]);
        return $this;
    }
    
    /**
     * Set factories.
     * @param array<string, string|callable> $factories
     * @return ServiceManager
     */
    public function setFactories(array $factories)
    {
        $this->_factories = array();
        foreach ($factories as $name => $factory) {
            $this->addFactory($name, $factory);
        }
        return $this;
    }
    
    /**
     * Get factories.
     * @return array<string, string|callable>
     */
    public function getFactories()
    {
        return $this->_factories;
    }
    
    /**
     * Create new service instance.
     * @param string $name
     * @throws Exception
     * @return object
     */
    public function createService($name)
    {
        $factory = $this->getFactory($name);
        if (is_callable($factory)) {
            $service = call_user_func($factory);
        } else {
            if (class_exists($factory)) {
                $service = new $factory();
            } else {
                throw new Exception("There is no class '$factory'");
            }
        }
    
        if ($service instanceof ServiceManagerAwareInterface) {
            $service->setServiceManager($this);
        }
    
        return $service;
    }
    
    /**
     * Set service instance.
     * @param string $name
     * @param object $service
     * @return ServiceManager
     */
    public function setService($name, $service)
    {
        $this->_services[$name] = $service;
        return $this;
    }
    
    /**
     * Has service?
     * @param string $name
     * @return boolean
     */
    public function hasService($name)
    {
        return isset($this->_services[$name]);
    }
    
    /**
     * Get or create service instance.
     * @param string $name
     * @return object
     */
    public function getService($name)
    {
        if (!isset($this->_services[$name])) {
            $this->setService($name, $this->createService($name));
        }
        return $this->_services[$name];
    }
    
    /**
     * Remove service.
     * @param string $name
     * @return ServiceManager
     */
    public function removeService($name)
    {
        unset($this->_services[$name]);
        return $this;
    }
    
    /**
     * Set services.
     * @param array<string, object> $services
     * @return ServiceManager
     */
    public function setServices(array $services)
    {
        $this->_services = array();
        foreach ($services as $name => $service) {
            $this->setService($name, $service);
        }
        return $this;
    }
    
    /**
     * Get services.
     * @return array<string, object>
     */
    public function getServices()
    {
        return $this->_services;
    }
    
}

