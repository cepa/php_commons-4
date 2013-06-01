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
use Commons\Buffer\OutputBuffer;
use Commons\Http\Request;
use Commons\Http\Response;
use Commons\Light\Controller\AbstractController;

class HttpDispatcher extends AbstractDispatcher
{
    /**
     * @var string
     */
    protected $_baseUri;
    /**
     * @var string
     */
    protected $_defaultModule = 'default';
    /**
     * @var string
     */
    protected $_moduleNamespaces;

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
        if (empty($this->_baseUri)) {
            $this->setBaseUri(Request::extractBaseUri());
        }
        return $this->_baseUri;
    }
    
    /**
     * Set default module.
     * @param string $module
     * @return \Commons\Light\Dispatcher\HttpDispatcher
     */
    public function setDefaultModule($module, $namespace = null)
    {
        $this->_defaultModule = $module;
        if (isset($namespace)) {
            $this->setModuleNamespace($module, $namespace);
        }
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
     * @throws Exception
     * @return string
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
     * Dispatch controller.
     * @param array $customParams
     * @throws Exception
     * @return AbstractController
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
            OutputBuffer::start();
            Autoloader::loadClass($controllerClass);
            /** @var $controller AbstractController */
            $controller = new $controllerClass($this->getRequest(), $this->getResponse());
            $controller->dispatch($params);
            $this->getResponse()->prependBody(OutputBuffer::end());
        } catch (AutoloaderException $e) {
            throw new Exception("Cannot find controller '{$controllerClass}'");
        }
        
        $this->getResponse()->send();
        
        return $this;
    }

    /**
     * @return array|bool
     */
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

    /**
     * @return $this|array
     */
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
