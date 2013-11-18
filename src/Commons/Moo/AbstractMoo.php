<?php

/**
 * =============================================================================
 * @file       Commons/Moo/AbstractMoo.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Moo;

use Commons\Buffer\OutputBuffer;
use Commons\Callback\Callback;
use Commons\Http\Response;
use Commons\Http\Request;
use Commons\Http\StatusCode;
use Commons\Plugin\PluginBroker;
use Commons\Plugin\PluginAwareInterface;
use Commons\Light\Route\RestRoute;
use Commons\Light\Route\RouteInterface;
use Commons\Light\Renderer\LayoutRenderer;
use Commons\Light\Renderer\RendererInterface;
use Commons\Light\View\ViewInterface;
use Commons\Light\View\PhtmlView;
use Commons\Utils\DebugUtils;

abstract class AbstractMoo implements PluginAwareInterface
{

    protected $_baseUri;
    protected $_requestFactory;
    protected $_request;
    protected $_responseFactory;
    protected $_response;
    protected $_renderer;
    protected $_callbacks = array();
    protected $_routes = array();
    protected $_pluginBroker;

    /**
     * Set base uri.
     * @param string $baseUri
     * @return \Commons\Moo\AbstractMoo
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
     * Set request factory;
     * @param mixed $callable
     * @return \Commons\Moo\AbstractMoo
     */
    public function setRequestFactory($callable)
    {
        if (!($callable instanceof Callback)) {
            $callable = new Callback($callable);
        }
        $this->_requestFactory = $callable;
        return $this;
    }

    /**
     * Get request factory.
     * @return Commons\Callback\Callback
     */
    public function getRequestFactory()
    {
        if (!isset($this->_requestFactory)) {
            $moo = $this;
            $this->setRequestFactory(function() use($moo){
                return Request::processHttpRequest($moo->getBaseUri());
            });
        }
        return $this->_requestFactory;
    }

    /**
     * Set request.
     * @param \Commons\Http\Request $request
     * @return \Commons\Moo\AbstractMoo
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
            $this->setRequest($this->getRequestFactory()->call());
        }
        return $this->_request;
    }

    /**
     * Set response factory;
     * @param mixed $callable
     * @return \Commons\Moo\AbstractMoo
     */
    public function setResponseFactory($callable)
    {
        if (!($callable instanceof Callback)) {
            $callable = new Callback($callable);
        }
        $this->_responseFactory = $callable;
        return $this;
    }

    /**
     * Get response factory.
     * @return Commons\Callback\Callback
     */
    public function getResponseFactory()
    {
        if (!isset($this->_responseFactory)) {
            $moo = $this;
            $this->setResponseFactory(function() use($moo){
                return new Response();
            });
        }
        return $this->_responseFactory;
    }

    /**
     * Set response.
     * @param \Commons\Http\Response $response
     * @return \Commons\Moo\AbstractMoo
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
            $this->setResponse($this->getResponseFactory()->call());
        }
        return $this->_response;
    }

    /**
     * Set renderer.
     * @param RendererInterface $renderer
     * @return \Commons\Moo\AbstractMoo
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
     * @return \Commons\Moo\AbstractMoo
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
            throw new Exception("No callback for key '{$key}'", StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->_callbacks[$key];
    }

    /**
     * Remove callback.
     * @param string $key
     * @return \Commons\Moo\AbstractMoo
     */
    public function removeCallback($key)
    {
        unset($this->_callbacks[$key]);
        return $this;
    }

    /**
     * Set callbacks.
     * @param array $callbacks
     * @return \Commons\Moo\AbstractMoo
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
     * @return \Commons\Moo\AbstractMoo
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
            throw new Exception("No route for key '{$key}'", StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->_routes[$key];
    }

    /**
     * Remove route.
     * @param string $key
     * @return \Commons\Moo\AbstractMoo
     */
    public function removeRoute($key)
    {
        unset($this->_routes[$key]);
        return $this;
    }

    /**
     * Set routes.
     * @param array $routes
     * @return \Commons\Moo\AbstractMoo
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
     * Set init callback.
     * This callback will be executed at the beginning.
     * @param mixed $callback
     * @return \Commons\Moo\AbstractMoo
     */
    public function init($callback)
    {
        return $this->setCallback('init', $callback);
    }

    /**
     * Set error callback.
     * @param mixed $callback
     * @return \Commons\Moo\AbstractMoo
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
     * @return \Commons\Moo\AbstractMoo
     */
    public function action($method, $uri, $callback)
    {
        $uri = trim($uri, '/');
        $key = (empty($method) ? '' : $method.' ').$uri;
        $this->setCallback($key, $callback);
        $this->setRoute($key, new RestRoute($method, $uri));
        return $this;
    }

    /**
     * Route uri to the closure for any method.
     * @param string $uri
     * @param mixed $callback
     * @return \Commons\Moo\AbstractMoo
     */
    public function route($uri, $callback)
    {
        return $this->action('', $uri, $callback);
    }

    /**
     * HTTP HEAD action.
     * @param string $uri
     * @param mixed $callback
     * @return \Commons\Moo\AbstractMoo
     */
    public function head($uri, $callback)
    {
        return $this->action('HEAD', $uri, $callback);
    }

    /**
     * HTTP GET action.
     * @param string $uri
     * @param mixed $callback
     * @return \Commons\Moo\AbstractMoo
     */
    public function get($uri, $callback)
    {
        return $this->action('GET', $uri, $callback);
    }

    /**
     * HTTP POST action.
     * @param string $uri
     * @param mixed $callback
     * @return \Commons\Moo\AbstractMoo
     */
    public function post($uri, $callback)
    {
        return $this->action('POST', $uri, $callback);
    }

    /**
     * HTTP PUT action.
     * @param string $uri
     * @param mixed $callback
     * @return \Commons\Moo\AbstractMoo
     */
    public function put($uri, $callback)
    {
        return $this->action('PUT', $uri, $callback);
    }

    /**
     * HTTP DELETE action.
     * @param string $uri
     * @param mixed $callback
     * @return \Commons\Moo\AbstractMoo
     */
    public function delete($uri, $callback)
    {
        return $this->action('DELETE', $uri, $callback);
    }

    /**
     * HTTP TRACE action.
     * @param string $uri
     * @param mixed $callback
     * @return \Commons\Moo\AbstractMoo
     */
    public function trace($uri, $callback)
    {
        return $this->action('TRACE', $uri, $callback);
    }

    /**
     * HTTP OPTIONS action.
     * @param string $uri
     * @param mixed $callback
     * @return \Commons\Moo\AbstractMoo
     */
    public function options($uri, $callback)
    {
        return $this->action('OPTIONS', $uri, $callback);
    }

    /**
     * HTTP CONNECT action.
     * @param string $uri
     * @param mixed $callback
     * @return \Commons\Moo\AbstractMoo
     */
    public function connect($uri, $callback)
    {
        return $this->action('CONNECT', $uri, $callback);
    }

    /**
     * The MOO! dispatcher.
     * @throws Exception
     * @return \Commons\Http\Response
     */
    public function moo()
    {
        return $this->_mooDispatcher();
    }

    /**
     * Register a closure callback.
     * @param string $name
     * @param mixed $callback
     * @return \Commons\Moo\AbstractMoo
     */
    public function closure($name, $callback)
    {
        return $this->setCallback($name, $callback);
    }

    /**
     * Alias to closure.
     * @param string $name
     * @param mixed $callback
     * @return \Commons\Moo\AbstractMoo
     */
    public function plugin($name, $callback)
    {
        return $this->closure($name, $callback);
    }

    /**
     * Run callback by name.
     * @param string $action
     * @param array $params
     * @return mixed
     */
    public function callAction($action, array $params = array())
    {
        return $this->getCallback($action)->callArray($params);
    }

    /**
     * Invoke a closure or a plugin.
     * @param string $name
     * @param array $arguments
     * @throws Exception
     * @return \Commons\Callback\Callback
     */
    public function __call($name, array $args = array())
    {
        if ($this->hasCallback($name)) {
            $params = array($this);
            foreach ($args as $arg) {
                $params[] = $arg;
            }
            return $this->callAction($name, $params);
        }
        return $this->getPluginBroker()->invoke($this, $name, $args);
    }

    protected function _mooDispatcher()
    {
        try {
            OutputBuffer::start();

            if ($this->hasCallback('init')) {
                $this->getCallback('init')->call($this);
            }

            foreach ($this->getRoutes() as $key => $route) {
                $params = $route->match($this->getRequest());
                if (is_array($params)) {
                    $this->setRoutes(array());
                    $params[0] = $this;
                    return $this->_mooActionExecutor($key, $params);
                }
            }

            throw new Exception("Unknown route ".$this->getRequest()->getMethod()." /".$this->getRequest()->getUri(), StatusCode::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            if ($this->hasCallback('error')) {
                try {
                    return $this->_mooActionExecutor('error', array($this, $e));
                } catch (\Exception $e) {
                    DebugUtils::renderExceptionPage($e);
                }
            } else {
                DebugUtils::renderExceptionPage($e);
            }
        }
        return $this->getResponse();
    }

    protected function _mooActionExecutor($action, array $params = array())
    {
        $result = $this->callAction($action, $params);
        $content = OutputBuffer::end();
        if ($result instanceof Response) {
            return $result;
        }
        $response = $this->getResponse();
        $response->appendBody($content);
        if ($result instanceof ViewInterface) {
            $response->appendBody($this->getRenderer()->render($result));
        }
        return $response;
    }

}
