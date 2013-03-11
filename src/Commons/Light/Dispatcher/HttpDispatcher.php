<?php

/**
 * =============================================================================
 * @file        Commons/Light/Dispatcher/HttpDispatcher.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\Dispatcher;

use Commons\Autoloader\Exception as AutoloaderException;
use Commons\Autoloader\DefaultAutoloader as Autoloader;
use Commons\Http\Request;
use Commons\Http\Response;
use Commons\Light\Route\RouteInterface;


class HttpDispatcher extends AbstractDispatcher
{
    
    protected $_baseUri;
    protected $_defaultModule = 'default';
    protected $_moduleNamespaces;
    protected $_routes = array();

    /**
     * Set base uri.
     * @param string $baseUri
     * @return \Commons\Light\Dispatcher\HttpDispatcher
     */
    public function setBaseUri($baseUri)
    {
        $this->_baseUri = $baseUri;
        return $this;
    }
    
    /**
     * Get base uri.
     * @return string
     */
    public function getBaseUri()
    {
        return $this->_baseUri;
    }
    
    /**
     * Set default module.
     * @param string $module
     * @return \Commons\Light\Dispatcher\HttpDispatcher
     */
    public function setDefaultModule($module)
    {
        $this->_defaultModule = $module;
        return $this;
    }
    
    /**
     * Get default module.
     * @return string
     */
    public function getDefaultModule()
    {
        return $this->_defaultModule;
    }
    
    /**
     * Set module namespace.
     * @param string $module
     * @param string $namespace
     * @return \Commons\Light\Dispatcher\HttpDispatcher
     */
    public function setModuleNamespace($module, $namespace)
    {
        $this->_moduleNamespaces[$module] = $namespace;
        return $this;
    }
    
    /**
     * Get module namespace.
     * @param string $module
     * @throws NotFoundException
     */
    public function getModuleNamespace($module)
    {
        if (!isset($this->_moduleNamespaces[$module])) {
            throw new Exception("Unknown module '{$module}'");
        }
        return $this->_moduleNamespaces[$module];
    }
    
    /**
     * Has module namespace.
     * @param string $module
     * @return boolean
     */
    public function hasModuleNamespace($module)
    {
        return (isset($this->_moduleNamespaces[$module]) ? true : false);
    }
    
    /**
     * Remove module namespace.
     * @param string $module
     * @return \Commons\Light\Dispatcher\HttpDispatcher
     */
    public function removeModuleNamespace($module)
    {
        unset($this->_moduleNamespaces[$module]);
        return $this;
    }
    
    /**
     * Set module namespaces.
     * @param array $namespaces
     * @return \Commons\Light\Dispatcher\HttpDispatcher
     */
    public function setModuleNamespaces(array $namespaces)
    {
        foreach ($namespaces as $module => $namespace) {
            $this->setModuleNamespace($module, $namespace);
        }
        return $this;
    }
    
    /**
     * Get module namespaces.
     * @return array
     */
    public function getModuleNamespaces()
    {
        return $this->_moduleNamespaces;
    }
    
    /**
     * Clear module namespaces.
     * @return \Commons\Light\Dispatcher\HttpDispatcher
     */
    public function clearModuleNamespaces()
    {
        $this->_moduleNamespaces = array();
        return $this;
    }
    
    /**
     * Override getRequest.
     * @see \Commons\Light\Dispatcher\AbstractDispatcher::getRequest()
     */
    public function getRequest()
    {
        if (!isset($this->_request)) {
            $this->_request = Request::processHttpRequest($this->getBaseUri());
        }
        return $this->_request;
    }
    
    /**
     * Set route.
     * @param string $name
     * @param RouteInterface $route
     * @return \Commons\Light\Dispatcher\HttpDispatcher
     */
    public function setRoute($name, RouteInterface $route)
    {
        $this->_routes[$name] = $route;
        return $this;
    }
    
    /**
     * Get route.
     * @param string $name
     * @throws Exception
     * @return multitype:
     */
    public function getRoute($name)
    {
        if (!isset($this->_routes[$name])) {
            throw new Exception("Cannot find route '{$name}'");
        }
        return $this->_routes[$name];
    }
    
    /**
     * Has route.
     * @param string $name
     * @return boolean
     */
    public function hasRoute($name)
    {
        return (isset($this->_routes[$name]) ? true : false);
    }
    
    /**
     * Remove route.
     * @param string $name
     * @return \Commons\Light\Dispatcher\HttpDispatcher
     */
    public function removeRoute($name)
    {
        unset($this->_routes[$name]);
        return $this;
    }
    
    /**
     * Add routes.
     * @param array $routes
     * @return \Commons\Light\Dispatcher\HttpDispatcher
     */
    public function addRoutes(array $routes)
    {
        foreach ($routes as $name => $route) {
            $this->setRoute($name, $route);
        }
        return $this;
    }
    
    /**
     * Get routes.
     * @return array
     */
    public function getRoutes()
    {
        return $this->_routes;
    }
    
    /**
     * Clear routes.
     * @return \Commons\Light\Dispatcher\HttpDispatcher
     */
    public function clearRoutes()
    {
        $this->_routes = array();
        return $this;
    }
    
    /**
     * Dispatch controller.
     * @param array $customParams
     * @returns AbstractDispatcher
     */
    public function dispatch(array $customParams = array())
    {
        $params = array(
            'module'     => $this->getDefaultModule(),
            'controller' => 'index',
            'action'     => 'index'
        );
        $routeParams = $this->_getParamsFromRoutes();
        if (is_array($routeParams)) {
            $params = array_merge($params, $routeParams);
        } else {
            $defaultParams = $this->_getParamsFromDefaultRouting();
            if (is_array($defaultParams)) {
                $params = array_merge($params, $defaultParams);
            }
        }
        $params = array_merge($params, $customParams);
        foreach ($params as $name => $value) {
            $this->getRequest()->setParam($name, $value);
        }
        
        $moduleName = $params['module'];
        $controllerName = $params['controller'];
        $namespace = $this->getModuleNamespace($moduleName);
        
        $controllerClass = str_replace('-', ' ', $controllerName);
        $controllerClass = str_replace(' ', '', ucwords($controllerClass));
        $controllerClass .= 'Controller';
        $controllerClass = $namespace.$controllerClass;
        
        try {
            Autoloader::loadClass($controllerClass);
            $controller = new $controllerClass($this->getRequest(), $this->getResponse());
            $controller->dispatch($params);
        } catch (AutoloaderException $e) {
            throw new Exception("Cannot find controller '{$controllerClass}'");
        }
        
        $this->getResponse()->send();
        
        return $this;
    }
    
    protected function _getParamsFromRoutes()
    {
        foreach ($this->getRoutes() as $name => $route) {
            $params = $route->match($this->getRequest());
            if (is_array($params)) {
                return $params;
            }
        }
        return false;
    }
    
    protected function _getParamsFromDefaultRouting()
    {
        $uri = $this->getRequest()->getUri();
        if (preg_match('#^([a-zA-Z0-9\-]+)\/([a-zA-Z0-9\-]+)\/([a-zA-Z0-9\-]+)#', $uri, $matches)) {
            return array(
                'module'     => $matches[1],
                'controller' => $matches[2],
                'action'     => $matches[3]
            );
       
        } else if (preg_match('#^([a-zA-Z0-9\-]+)\/([a-zA-Z0-9\-]+)#', $uri, $matches)) {
            return array(
                'controller' => $matches[1],
                'action'     => $matches[2]
            );
        
        } else if (preg_match('#^([a-zA-Z0-9\-]+)#', $uri, $matches)) {
            return array('controller' => $matches[1]);
        }
        return $this;
    }
}
