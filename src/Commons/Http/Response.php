<?php

/**
 * =============================================================================
 * @file        Commons/Http/Response.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Http;

use Commons\Exception\NotFoundException;

class Response
{

    public $_body = '';
    public $_headers = array();
    public $_statusCode = StatusCode::HTTP_OK;
    public $_statusMessage = 'OK';
    
    /**
     * Append body.
     * @param string $body
     * @return \Commons\Http\Response
    */
    public function appendBody($body)
    {
        $this->_body .= $body;
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
     * Clear body.
     * @return \Commons\Http\Response
     */
    public function clearBody()
    {
        $this->_body = '';
        return $this;
    }
    
    /**
     * Set headers.
     * @param array $headers
     * @return \Commons\Http\Response
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
     * @return \Commons\Http\Response
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
     * @return \Commons\Http\Response
     */
    public function setHeader($name, $value)
    {
        $this->_headers[$name] = $value;
        return $this;
    }
    
    /**
     * Get header.
     * @param string $name
     * @throws \Commons\Exception\NotFoundException
     * @return string
     */
    public function getHeader($name)
    {
        if (!isset($this->_headers[$name])) {
            throw new NotFoundException();
        }
        return $this->_headers[$name];
    }
    
    /**
     * Has header.
     * @param boolean $name
     * @return bool
     */
    public function hasHeader($name)
    {
        return isset($this->_headers[$name]);
    }
    
    /**
     * Remove header.
     * @param string $name
     * @return \Commons\Http\Response
     */
    public function removeHeader($name)
    {
        unset($this->_headers[$name]);
        return $this;
    }
    
    /**
     * Set status.
     * @param int $code
     * @param string $message
     * @return \Commons\Http\Response
     */
    public function setStatus($code, $message = null)
    {
        $this->_statusCode = $code;
        if (isset($message)) {
            $this->_statusMessage = $message;
        } else {
            $this->_statusMessage = StatusCode::getMessage($code);
        }
        return $this;
    }
    
    /**
     * Get status code.
     * @return int
     */
    public function getStatusCode()
    {
        return $this->_statusCode;
    }
    
    /**
     * Get status message.
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->_statusMessage;
    }
    
    /**
     * Send response to the output.
     */
    public function send()
    {
        header('HTTP/1.1 '.$this->getStatusCode().' '.$this->getStatusMessage());
        foreach ($this->_headers as $name => $value) {
            header($name.': '.$value, true);
        }
        echo $this->_body;
    }
        
}
