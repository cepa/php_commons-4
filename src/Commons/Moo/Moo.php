<?php

/**
 * =============================================================================
 * @file        Commons/Moo/Moo.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Moo;

use Commons\Buffer\OutputBuffer;
use Commons\Callback\Callback;
use Commons\Http\Response;
use Commons\Http\Request;
use Commons\Light\Route\RestRoute;
use Commons\Light\Route\RouteInterface;
use Commons\Light\Renderer\LayoutRenderer;
use Commons\Light\Renderer\RendererInterface;
use Commons\Light\View\ViewInterface;
use Commons\Light\View\TemplateView;
use Commons\Utils\DebugUtils;

class Moo
{
    
    protected $_baseUri;
    protected $_request;
    protected $_response;
    protected $_renderer;
    protected $_callbacks = array();
    protected $_routes = array();
    
    /**
     * Set base uri.
     * @param string $baseUri
     * @return \Commons\Moo\Moo
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
        if (!isset($this->_baseUri)) {
            $this->setBaseUri(Request::extractBaseUri());
        }
        return $this->_baseUri;
    }
    
    /**
     * Set request.
     * @param \Commons\Http\Request $request
     * @return \Commons\Moo\Moo
     */
    public function setRequest(Request $request)
    {
        $this->_request = $request;
        return $this;
    }
    
    /**
     * Get request.
     * @return \Commons\Http\Request
     */
    public function getRequest()
    {
        if (!isset($this->_request)) {
            $this->setRequest(Request::processHttpRequest($this->getBaseUri()));
        }
        return $this->_request;
    }
    
    /**
     * Set response.
     * @param \Commons\Http\Response $response
     * @return \Commons\Moo\Moo
     */
    public function setResponse(Response $response)
    {
        $this->_response = $response;
        return $this;
    }
    
    /**
     * Get response.
     * @return \Commons\Http\Response
     */
    public function getResponse()
    {
        if (!isset($this->_response)) {
            $this->setResponse(new Response());
        }
        return $this->_response;
    }
    
    /**
     * Set renderer.
     * @param RendererInterface $renderer
     * @return \Commons\Moo\Moo
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->_renderer = $renderer;
        return $this;
    }
    
    /**
     * Get renderer.
     * @return RendererInterface
     */
    public function getRenderer()
    {
        if (!isset($this->_renderer)) {
            $this->setRenderer(new LayoutRenderer());
        }
        return $this->_renderer;
    }
    
    /**
     * Set callback.
     * @param string $key
     * @param mixed $callback
     * @return \Commons\Moo\Moo
     */
    public function setCallback($key, $callback)
    {
        if (!($callback instanceof Callback)) {
            $callback = new Callback($callback);
        }
        $this->_callbacks[$key] = $callback;
        return $this;
    }
    
    /**
     * Has callback?
     * @param string $key
     * @return boolean
     */
    public function hasCallback($key)
    {
        return isset($this->_callbacks[$key]);
    }
    
    /**
     * Get callback.
     * @param string $key
     * @throws Exception
     * @return \Commons\Callback\Callback
     */
    public function getCallback($key)
    {
        if (!$this->hasCallback($key)) {
            throw new Exception("No callback for key '{$key}'");
        }
        return $this->_callbacks[$key];
    }
    
    /**
     * Remove callback.
     * @param string $key
     * @return \Commons\Moo\Moo
     */
    public function removeCallback($key)
    {
        unset($this->_callbacks[$key]);
        return $this;
    }
    
    /**
     * Set callbacks.
     * @param array $callbacks
     * @return \Commons\Moo\Moo
     */
    public function setCallbacks(array $callbacks)
    {
        $this->_callbacks = array();
        foreach ($callbacks as $key => $callback) {
            $this->setCallback($key, $callback);
        }
        return $this;
    }
    
    /**
     * Get callbacks.
     * @return array<\Commons\Callback\Callback>
     */
    public function getCallbacks()
    {
        return $this->_callbacks;
    }
    
    /**
     * Set route.
     * @param string $key
     * @param RouteInterface $route
     * @return \Commons\Moo\Moo
     */
    public function setRoute($key, RouteInterface $route)
    {
        $this->_routes[$key] = $route;
        return $this;
    }
    
    /**
     * Has route?
     * @param string $key
     * @return boolean
     */
    public function hasRoute($key)
    {
        return isset($this->_routes[$key]);
    }
    
    /**
     * Get route.
     * @param string $key
     * @throws Exception
     * @return \Commons\Light\Route\RouteInterface
     */
    public function getRoute($key)
    {
        if (!$this->hasRoute($key)) {
            throw new Exception("No route for key '{$key}'");
        }
        return $this->_routes[$key];
    }
    
    /**
     * Remove route.
     * @param string $key
     * @return \Commons\Moo\Moo
     */
    public function removeRoute($key)
    {
        unset($this->_routes[$key]);
        return $this;
    }
    
    /**
     * Set routes.
     * @param array $routes
     * @return \Commons\Moo\Moo
     */
    public function setRoutes(array $routes)
    {
        $this->_routes = array();
        foreach ($routes as $key => $route) {
            $this->setRoute($key, $route);
        }
        return $this;
    }
    
    /**
     * Get routes.
     * @return array<\Commons\Light\Route\RouteInterface>
     */
    public function getRoutes()
    {
        return $this->_routes;
    }
    
    /**
     * Set init callback.
     * This callback will be executed at the beginning.
     * @param mixed $callback
     * @return \Commons\Moo\Moo
     */
    public function init($callback)
    {
        return $this->setCallback('init', $callback);
    }
    
    /**
     * Set error callback.
     * @param mixed $callback
     * @return \Commons\Moo\Moo
     */
    public function error($callback)
    {
        return $this->setCallback('error', $callback);
    }
    
    /**
     * Set action.
     * @param string $method
     * @param string $uri
     * @param mixed $callback
     * @return \Commons\Moo\Moo
     */
    public function action($method, $uri, $callback)
    {
        $uri = trim($uri, '/');
        $key = $method.' '.$uri;
        $this->setCallback($key, $callback);
        $this->setRoute($key, new RestRoute($method, $uri));
        return $this;
    }
    
    /**
     * HTTP GET action.
     * @param string $uri
     * @param mixed $callback
     * @return \Commons\Moo\Moo
     */
    public function get($uri, $callback)
    {
        return $this->action('GET', $uri, $callback);
    }
    
    /**
     * HTTP POST action.
     * @param string $uri
     * @param mixed $callback
     * @return \Commons\Moo\Moo
     */
    public function post($uri, $callback)
    {
        return $this->action('POST', $uri, $callback);
    }
    
    /**
     * HTTP PUT action.
     * @param string $uri
     * @param mixed $callback
     * @return \Commons\Moo\Moo
     */
    public function put($uri, $callback)
    {
        return $this->action('PUT', $uri, $callback);
    }
    
    /**
     * HTTP DELETE action.
     * @param string $uri
     * @param mixed $callback
     * @return \Commons\Moo\Moo
     */
    public function delete($uri, $callback)
    {
        return $this->action('DELETE', $uri, $callback);
    }
    
    /**
     * The MOO! dispatcher.
     * @throws Exception
     * @return \Commons\Moo\Moo
     */
    public function moo()
    {
        try {
            OutputBuffer::start();
            
            if ($this->hasCallback('init')) {
                $this->getCallback('init')->call($this);
            }

            foreach ($this->getRoutes() as $key => $route) {
                $params = $route->match($this->getRequest());
                if (is_array($params)) {
                    $params[0] = $this;
                    $view = $this->getCallback($key)->callArray($params);
                    $content = OutputBuffer::end();
                    $this->getResponse()->appendBody($content);
                    return $this->_renderView($view);
                }
            }
            
            throw new Exception("Error 404");
            
        } catch (\Exception $e) {
            if ($this->hasCallback('error')) {
                try {
                    $view = $this->getCallback('error')->call($this, $e);
                    return $this->_renderView($view);
                } catch (\Exception $e) {
                    DebugUtils::renderExceptionPage($e);
                }
            } else {
                DebugUtils::renderExceptionPage($e);
            }
        }
        return $this;
    }
    
    /**
     * Register a closure callback.
     * @param string $name
     * @param mixed $callback
     * @return \Commons\Moo\Moo
     */
    public function closure($name, $callback)
    {
        return $this->setCallback($name, $callback);
    }
    
    /**
     * Call a plugin.
     * @param string $name
     * @param array $arguments
     * @throws Exception
     * @return \Commons\Callback\Callback
     */
    public function __call($name, $arguments)
    {
        if (!$this->hasCallback($name)) {
            throw new Exception("Unknown plugin '{$name}'");
        }
        $params = array($this);
        foreach ($arguments as $argument) {
            $params[] = $argument;
        }
        return $this->getCallback($name)->callArray($params);
    }
    
    protected function _renderView($view)
    {

        if (!($view instanceof ViewInterface)) {
            $view = new TemplateView();
        }
        
        $this->getResponse()
            ->appendBody($this->getRenderer()->render($view))
            ->send();
        return $this;
    }
    
}
