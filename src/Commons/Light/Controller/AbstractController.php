<?php

/**
 * =============================================================================
 * @file       Commons/Light/Controller/AbstractController.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\Controller;

use Commons\Http\Request;
use Commons\Http\Response;
use Commons\Plugin\Broker as PluginBroker;
use Commons\Plugin\Exception as PluginException;
use Commons\Plugin\PluginAwareInterface;

abstract class AbstractController implements PluginAwareInterface
{
    
    protected $_request;
    protected $_response;
    protected $_resourcesPath;
    protected $_pluginBroker;
    
    /**
     * Init constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request = null, Response $response = null)
    {
        if (isset($request)) {
            $this->setRequest($request);
        }
        if (isset($response)) {
            $this->setResponse($response);
        }
        $this->init();
    }
    
    /**
     * Init hook.
     */
    public function init()
    {
        
    }
    
    /**
     * Set http request.
     * @param Request $request
     * @return \Commons\Light\Controller\AbstractController
     */
    public function setRequest(Request $request)
    {
        $this->_request = $request;
        return $this;
    }
    
    /**
     * Get http request.
     * @return Request
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
     * @return \Commons\Light\Controller\AbstractController
     */
    public function setResponse(Response $response)
    {
        $this->_response = $response;
        return $this;
    }
    
    /**
     * Get http response.
     * @return Response
     */
    public function getResponse()
    {
        if (!isset($this->_response)) {
            $this->_response = new Response();
        }
        return $this->_response;
    }
    
    /**
     * Set resources path.
     * @param string $path
     * @return \Commons\Light\Controller\AbstractController
     */
    public function setResourcesPath($path)
    {
        $this->_resourcesPath = $path;
        return $this;
    }
    
    /**
     * Get resources path.
     * If not set then generate relative path based on the controller name.
     * @return string
     */
    public function getResourcesPath()
    {
        if (!isset($this->_resourcesPath)) {
            $controllerClass = str_replace('\\', '/', get_class($this));
            $this->_resourcesPath = dirname(dirname($controllerClass)).'/Resources';
        }
        return $this->_resourcesPath;
    }
    
    /**
     * Set plugin broker.
     * @see \Commons\Plugin\PluginAwareInterface::setPluginBroker()
     */
    public function setPluginBroker(PluginBroker $pluginBroker)
    {
        $this->_pluginBroker = $pluginBroker;
        return $this;
    }
    
    /**
     * Get plugin broker.
     * @see \Commons\Plugin\PluginAwareInterface::getPluginBroker()
     */
    public function getPluginBroker()
    {
        if (!isset($this->_pluginBroker)) {
            $pluginBroker = new PluginBroker();
            $pluginBroker->addNamespace('Commons\Http\Plugin');
            $this->setPluginBroker($pluginBroker);
        }
        return $this->_pluginBroker;
    }
    
    /**
     * Dispatch method.
     * @param array $params
     * @return \Commons\Light\View\ViewInterface
     */
    public function dispatch(array $params = array())
    {
        throw Exception("Not implemented");
    }
    
    /**
     * Invoke plugin.
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function __call($name, array $args = array())
    {
        try {
            return $this->getPluginBroker()->invoke($this, $name, $args);
        } catch (PluginException $e) {
            throw new Exception($e);
        }
    }
    
}
