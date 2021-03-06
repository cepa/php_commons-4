<?php

/**
 * =============================================================================
 * @file       Commons/Light/Dispatcher/AbstractDispatcher.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\Dispatcher;

use Commons\Http\Request;
use Commons\Http\Response;
use Commons\Light\Route\RouteInterface;
use Commons\Service\ServiceManager;
use Commons\Service\ServiceManagerAwareInterface;
use Commons\Service\ServiceManagerInterface;

abstract class AbstractDispatcher implements ServiceManagerAwareInterface
{
    /**
     * @var Request
     */
    protected $_request;

    /**
     * @var Response
     */
    protected $_response;

    /**
     * @var RouteInterface[]
     */
    protected $_routes = array();
    
    /**
     * @var ServiceManagerInterface
     */
    protected $_serviceManager;
    
    /**
     * Set http request.
     * @param Request $request
     * @return \Commons\Light\Dispatcher\AbstractDispatcher
     */
    public function setRequest(Request $request)
    {
        $this->_request = $request;
        return $this;
    }
    
    /**
     * Get http request.
     * @return\Commons\Http\Request
     */
    public function getRequest()
    {
        if (!isset($this->_request)) {
            $this->_request = new Request();
        }
        return $this->_request;
    }
    
    /**
     * Set http response.
     * @param Response $response
     * @return \Commons\Light\Dispatcher\AbstractDispatcher
     */
    public function setResponse(Response $response)
    {
        $this->_response = $response;
        return $this;
    }
    
    /**
     * Get http response.
     * @return \Commons\Http\Response
     */
    public function getResponse()
    {
        if (!isset($this->_response)) {
            $this->_response = new Response();
        }
        return $this->_response;
    }
    
    /**
     * Set route.
     * @param string $name
     * @param RouteInterface $route
     * @return \Commons\Light\Dispatcher\AbstractDispatcher
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
     * @return RouteInterface[]
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
     * @return \Commons\Light\Dispatcher\AbstractDispatcher
     */
    public function removeRoute($name)
    {
        unset($this->_routes[$name]);
        return $this;
    }
    
    /**
     * Add routes.
     * @param array $routes
     * @return \Commons\Light\Dispatcher\AbstractDispatcher
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
     * @return RouteInterface[]
     */
    public function getRoutes()
    {
        return $this->_routes;
    }
    
    /**
     * Clear routes.
     * @return \Commons\Light\Dispatcher\AbstractDispatcher
     */
    public function clearRoutes()
    {
        $this->_routes = array();
        return $this;
    }
    
    /**
     * Set service manager.
     * @param ServiceManagerInterface $serviceManager
     * @return \Commons\Light\Dispatcher\AbstractDispatcher
     */
    public function setServiceManager(ServiceManagerInterface $serviceManager)
    {
        $this->_serviceManager = $serviceManager;
        return $this;
    }
    
    /**
     * Get service manager.
     * @throws Exception
     * @return \Commons\Service\ServiceManagerInterface
     */
    public function getServiceManager()
    {
        if (!isset($this->_serviceManager)) {
            $this->setServiceManager(new ServiceManager());
        }
        return $this->_serviceManager;
    }

    /**
     * Dispatch controller.
     * @param array $options
     * @throws Exception
     */
    public function dispatch(array $options = array())
    {
        throw new Exception("Not implemented");
    }
    
}
