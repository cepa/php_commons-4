<?php

/**
 * =============================================================================
 * @file       Commons/Http/Request.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Http;

class Request
{
    
    protected $_params = array();
    protected $_post = array();
    protected $_headers = array();
    protected $_method = 'GET';
    protected $_uri;
    protected $_body = '';
    protected $_authUsername;
    protected $_authPassword;
    
    /**
     * Set params.
     * @param array $params
     * @return \Commons\Http\Request
     */
    public function setParams(array $params)
    {
        $this->_params = $params;
        return $this;
    }
    
    /**
     * Get params.
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }
    
    /**
     * Clear params.
     * @return \Commons\Http\Request
     */
    public function clearParams()
    {
        $this->_params = array();
        return $this;
    }
    
    /**
     * Set param.
     * @param string $name
     * @param string $value
     * @return \Commons\Http\Request
     */
    public function setParam($name, $value)
    {
        $this->_params[$name] = $value;
        return $this;
    }
    
    /**
     * Get param.
     * @param string $name
     * @param string $defaultValue
     * @return string
     */
    public function getParam($name, $defaultValue = null)
    {
        if (isset($this->_params[$name])) {
            return $this->_params[$name];
        }
        return $defaultValue;
    }
    
    /**
     * Has param.
     * @param string $name
     * @return boolean
     */
    public function hasParam($name)
    {
        return isset($this->_params[$name]);
    }
    
    /**
     * Remove param.
     * @param string $name
     * @return \Commons\Http\Request
     */
    public function removeParam($name)
    {
        unset($this->_params[$name]);
        return $this;
    }
    
    /**
     * Set post data.
     * @param array $post
     * @return \Commons\Http\Request
     */
    public function setPostParams(array $post)
    {
        $this->_post = $post;
        return $this;
    }
    
    /**
     * Get post data.
     * @return array
     */
    public function getPostParams()
    {
        return $this->_post;
    }
    
    /**
     * Clear post data.
     * @return \Commons\Http\Request
     */
    public function clearPostParams()
    {
        $this->_post = array();
        return $this;
    }
    
    /**
     * Set post param.
     * @param string $name
     * @param string $value
     * @return \Commons\Http\Request
     */
    public function setPostParam($name, $value)
    {
        $this->_post[$name] = $value;
        return $this;
    }
    
    /**
     * Get post param.
     * @param string $name
     * @param string $defaultValue
     * @return string
     */
    public function getPostParam($name, $defaultValue = null)
    {
        if (isset($this->_post[$name])) {
            return $this->_post[$name];
        }
        return $defaultValue;
    }
    
    /**
     * Has post param.
     * @param string $name
     * @return boolean
     */
    public function hasPostParam($name)
    {
        return isset($this->_post[$name]);
    }
    
    /**
     * Remove post param.
     * @param string $name
     * @return \Commons\Http\Request
     */
    public function removePostParam($name)
    {
        unset($this->_post[$name]);
        return $this;
    }
    
    /**
     * Set headers.
     * @param array $headers
     * @return \Commons\Http\Request
     */
    public function setHeaders(array $headers)
    {
        $this->_headers = $headers;
        return $this;
    }
    
    /**
     * Get headers.
     * @return array
     */
    public function getHeaders()
    {
        return $this->_headers;
    }
    
    /**
     * Clear headers.
     * @return \Commons\Http\Request
     */
    public function clearHeaders()
    {
        $this->_headers = array();
        return $this;
    }
    
    /**
     * Set header.
     * @param string $name
     * @param string $value
     * @return \Commons\Http\Request
     */
    public function setHeader($name, $value)
    {
        $this->_headers[$name] = $value;
        return $this;
    }
    
    /**
     * Get header.
     * @param string $name
     * @throws \Commons\Http\Exception
     * @return mixed
     */
    public function getHeader($name)
    {
        if (!isset($this->_headers[$name])) {
            throw new Exception("Header '{$name}' is not set");
        }
        return $this->_headers[$name];
    }
    
    /**
     * Has header.
     * @param string $name
     * @return boolean
     */
    public function hasHeader($name)
    {
        return isset($this->_headers[$name]);
    }
    
    /**
     * Remove header.
     * @param string $name
     * @return \Commons\Http\Request
     */
    public function removeHeader($name)
    {
        unset($this->_headers[$name]);
        return $this;
    }
    
    /**
     * Set method.
     * @param string $method
     * @return \Commons\Http\Request
     */
    public function setMethod($method)
    {
        $this->_method = strtoupper($method);
        return $this;
    }
    
    /**
     * Get method.
     * @return string
     */
    public function getMethod()
    {
        return $this->_method;
    }
    
    /**
     * Check if get method.
     * @return boolean
     */
    public function isGetRequest()
    {
        return ($this->_method == 'GET');
    }
    
    /**
     * Check if post method.
     * @return boolean
     */
    public function isPostRequest()
    {
        return ($this->_method == 'POST');
    }
    
    /**
     * Check if this is XMLHttpRequest (AJAX).
     * @return boolean
     */
    public function isAjaxRequest()
    {
        if ($this->hasHeader('X_REQUESTED_WITH')) {
            return ($this->getHeader('X_REQUESTED_WITH') == 'XMLHttpRequest');
        }
        return false;
    }
    
    /**
     * Set uri.
     * @param string $uri
     * @return \Commons\Http\Request
     */
    public function setUri($uri)
    {
        $this->_uri = $uri;
        return $this;
    }
    
    /**
     * Get uri.
     * @return string
     */
    public function getUri()
    {
        return $this->_uri;
    }
    
    /**
     * Set body.
     * @param string $body
     * @return \Commons\Http\Request
     */
    public function setBody($body)
    {
        $this->_body = $body;
        return $this;
    }
    
    /**
     * Get body.
     * @return string
     */
    public function getBody()
    {
        return $this->_body;
    }
    
    /**
     * Set http auth username.
     * @param string $username
     * @return \Commons\Http\Request
     */
    public function setAuthUsername($username)
    {
        $this->_authUsername = $username;
        return $this;
    }
    
    /**
     * Get http auth username.
     * @return string
     */
    public function getAuthUsername()
    {
        return $this->_authUsername;
    }
    
    /**
     * Set http auth password.
     * @param string $password
     * @return \Commons\Http\Request
     */
    public function setAuthPassword($password)
    {
        $this->_authPassword = $password;
        return $this;
    }
    
    /**
     * Get http auth password.
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->_authPassword;
    }
    
    /**
     * Process server http request.
     * @param string $baseUri
     * @return \Commons\Http\Request
     */
    public static function processHttpRequest($baseUri = null)
    {
        $method = 'GET';
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $method = $_SERVER['REQUEST_METHOD'];
        }
        
        $uri = '/';
        if (isset($_SERVER['REQUEST_URI'])) {
            if (isset($baseUri)) {
                $uri = $_SERVER['REQUEST_URI'];
                if (substr($uri, 0, strlen($baseUri)) == $baseUri) {
                    $uri = substr($uri, strlen($baseUri));
                    $uri = strtok($uri, '?');
                }
            } else {
                $uri = strtok($_SERVER['REQUEST_URI'], '?');
            }
        }
        $uri = trim($uri, '/');
        
        $request = new Request();
        $request
            ->setMethod($method)
            ->setUri($uri)
            ->setParams($_GET)
            ->setPostParams($_POST)
            ->setHeaders($_SERVER)
            ->setBody(file_get_contents('php://input'));
        
        if (isset($_SERVER['PHP_AUTH_USER'])) {
            $request->setAuthUsername($_SERVER['PHP_AUTH_USER']);
        }
        if (isset($_SERVER['PHP_AUTH_PW'])) {
            $request->setAuthPassword($_SERVER['PHP_AUTH_PW']);
        }
        
        return $request;
    }
    
    /**
     * Extract base uri from $_SERVER['SCRIPT_NAME']
     * @return string|null
     */
    public static function extractBaseUri()
    {
        if (isset($_SERVER['SCRIPT_NAME'])) {
            return dirname($_SERVER['SCRIPT_NAME']);
        }
        return null;
    }
    
}
