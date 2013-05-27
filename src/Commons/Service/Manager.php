<?php

/**
 * =============================================================================
 * @file        Commons/Service/Manager.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Service;

class Manager
{
    
    protected $_namespaces = array();
    protected $_instances = array();
    
    /**
     * Add namespace.
     * @param string $namespace
     * @return \Commons\Service\Manager
     */
    public function addNamespace($namespace)
    {
        $namespace = trim($namespace, '\\');
        $this->_namespaces[$namespace] = $namespace;
        return $this;
    }
    
    /**
     * Has namespace.
     * @param string $namespace
     * @return boolean
     */
    public function hasNamespace($namespace)
    {
        return isset($this->_namespaces[trim($namespace, '\\')]);
    }
    
    /**
     * Remove namespace.
     * @param string $namespace
     * @return \Commons\Service\Manager
     */
    public function removeNamespace($namespace)
    {
        unset($this->_namespaces[trim($namespace, '\\')]);
        return $this;
    }
    
    /**
     * Set namespaces.
     * @param array<string> $namespaces
     * @return \Commons\Service\Manager
     */
    public function setNamespaces(array $namespaces)
    {
        $this->_namespaces = array();
        foreach ($namespaces as $namespace) {
            $this->addNamespace($namespace);
        }
        return $this;
    }
    
    /**
     * Get namespaces.
     * @return array<string>
     */
    public function getNamespaces() 
    {
        return $this->_namespaces;
    }
    
    /**
     * Add service instance.
     * @param string $name
     * @param ServiceInterface $instance
     * @return \Commons\Service\Manager
     */
    public function addService($name, ServiceInterface $instance)
    {
        $this->_instances[$name] = $instance;
        return $this;
    }
    
    /**
     * Has plugin instance?
     * @param string $name
     * @return boolean
     */
    public function hasService($name)
    {
        return isset($this->_instances[$name]);
    }
    
    /**
     * Get or create plugin instance.
     * @param string $name
     * @throws Exception
     * @return \Commons\Service\ServiceInterface
     */
    public function getService($name)
    {
        if (!$this->hasService($name)) {
            foreach ($this->getNamespaces() as $namespace) {
                $class = '\\'.$namespace.'\\'.ucwords($name).'Service';
                if (class_exists($class)) {
                    $this->addService($name, new $class);
                }
            }
        }
        if (!$this->hasService($name)) {
            throw new Exception("Cannot find service '{$name}'");
        }
        return $this->_instances[$name];
    }
    
    /**
     * Remove plugin instance.
     * @param string $name
     * @return \Commons\Service\Manager
     */
    public function removeService($name)
    {
        unset($this->_instances[$name]);
        return $this;
    }

}

