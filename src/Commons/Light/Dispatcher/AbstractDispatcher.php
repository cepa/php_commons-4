<?php

/**
 * =============================================================================
 * @file        Commons/Light/Dispatcher/AbstractDispatcher.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\Dispatcher;

use Commons\Exception\NotImplementedException;
use Commons\Http\Request;
use Commons\Http\Response;

abstract class AbstractDispatcher
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
     * Dispatch controller.
     * @param array $options
     * @throws NotImplementedException
     */
    public function dispatch(array $options = array())
    {
        throw new NotImplementedException();
    }
    
}
