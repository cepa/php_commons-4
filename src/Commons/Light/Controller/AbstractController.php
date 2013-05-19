<?php

/**
 * =============================================================================
 * @file        Commons/Light/Controller/AbstractController.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\Controller;

use Commons\Http\Request;
use Commons\Http\Response;

abstract class AbstractController
{
    
    protected $_request;
    protected $_response;
    protected $_resourcesPath;
    
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
     * Dispatch method.
     * @param array $params
     * @return \Commons\Light\View\ViewInterface
     */
    public function dispatch(array $params = array())
    {
        throw Exception("Not implemented");
    }
    
}
