<?php

/**
 * =============================================================================
 * @file        Commons/Curl/Curl.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Curl;

use Commons\Xml\Reader as XmlReader;
use Commons\Json\Decoder as JsonDecoder;
use Commons\Exception\MissingDependencyException;
use Commons\Xml\Xml;

class Curl
{
    
    protected $_url;
    protected $_handle;
    protected $_response;
    protected $_responseCode;
    protected $_responseContentType;
    protected $_responseContentLength;
    
    /**
     * Init.
     * @param string $url
     * @param array $options
     * @throws MissingDependencyException
     * @throws Exception
     */
    public function __construct($url, array $options = array())
    {
        if (!function_exists('curl_init')) {
            throw new MissingDependencyException("Curl module is missing!");
        }
        
        $this->_url = $url;
        
        $this->_handle = curl_init($url);
        if (!$this->_handle) {
            throw new Exception("curl_init failed!");
        }
        
        // Default options.
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_FOLLOWLOCATION, true);
        
        if (count($options) > 0) {
            $this->setOptions($options);
        }
    }
    
    /**
     * Close curl handle.
     */
    public function __destruct()
    {
        curl_close($this->_handle);
    }
    
    /**
     * Get url.
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }
    
    /**
     * Get handle.
     * @return resource
     */
    public function getHandle()
    {
        return $this->_handle;
    }
    
    /**
     * Set curl option.
     * @param int $option
     * @param mixed $value
     * @return Curl
     */
    public function setOption($option, $value)
    {
        curl_setopt($this->_handle, $option, $value);
        return $this;
    }
    
    /**
     * Set curl options.
     * @param array $options
     * @return Curl
     */
    public function setOptions(array $options)
    {
        curl_setopt_array($this->_handle, $options);
        return $this;
    }
    
    /**
     * Get curl info.
     * @param int $option
     * @return mixed
     */
    public function getInfo($option)
    {
        return curl_getinfo($this->_handle, $option);
    }
    
    /**
     * Execute curl call.
     * @throws Exception
     * @return Curl
     */
    public function execute()
    {
        $this->_response = curl_exec($this->_handle);
        if (!$this->_response) {
            throw new Exception("curl_exec failed!");
        }
        
        $this->_responseCode = $this->getInfo(CURLINFO_HTTP_CODE);
        $this->_responseContentType = $this->getInfo(CURLINFO_CONTENT_TYPE);
        $this->_responseContentLength = $this->getInfo(CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        
        return $this;
    }
    
    /**
     * Set referrer.
     * @param string $referrer
     * @return Curl
     */
    public function setReferrer($referrer)
    {
        return $this->setOption(CURLOPT_REFERER, $referrer);
    }
    
    /**
     * Set user agent.
     * @param string $userAgent
     * @return Curl
     */
    public function setUserAgent($userAgent)
    {
        return $this->setOption(CURLOPT_USERAGENT, $userAgent);
    }
    
    /**
     * Set encoding.
     * @param string $encoding
     * @return Curl
     */
    public function setEncoding($encoding)
    {
        return $this->setOption(CURLOPT_ENCODING, $encoding);
    }
    
    /**
     * Set timeout.
     * @param string $timeout
     * @return Curl
     */
    public function setTimeout($timeout)
    {
        return $this->setOption(CURLOPT_TIMEOUT, $timeout);
    }
    
    /**
     * Get http response body.
     * @return string
     */
    public function getResponse()
    {
        return $this->_response;
    }
    
    /**
     * Get http status code of the response.
     * @return mixed
     */
    public function getResponseCode()
    {
        return $this->_responseCode;
    }
    
    /**
     * Get content type of the response.
     * @return mixed
     */
    public function getResponseContentType()
    {
        return $this->_responseContentType;
    }
    
    /**
     * Get content length of the response.
     * @return mixed
     */
    public function getResponseContentLength()
    {
        return $this->_responseContentLength;
    }
    
    /**
     * Parse json response.
     * @return mixed
     */
    public function parseJsonResponse()
    {
        $decoder = new JsonDecoder();
        return $decoder->decode($this->getResponse());
    }
    
    /**
     * Parse xml response.
     * @return Xml
     */
    public function parseXmlResponse()
    {
        $reader = new XmlReader();
        return $reader->readFromString($this->getResponse());
    }
    
}

