<?php

/**
 * =============================================================================
 * @file       Commons/Http/Response.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Http;

use Commons\Callback\Callback;

class Response
{

    protected $_body = '';
    protected $_headers = array();
    protected $_statusCode = StatusCode::HTTP_OK;
    protected $_statusMessage = 'OK';
    protected $_sender;

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
     * Prepend body.
     * @param string $body
     * @return \Commons\Http\Response
     */
    public function prependBody($body)
    {
        $this->_body = $body.$this->_body;
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
     * @throws \Commons\Http\Exception
     * @return string
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
     * Set sender callback.
     * @param callable $callable
     * @return \Commons\Http\Response
     */
    public function setSender($callable)
    {
        if (!($callable instanceof Callback)) {
            $callable = new Callback($callable);
        }
        $this->_sender = $callable;
        return $this;
    }

    /**
     * Get sender callback.
     * @return\Commons\Callback\Callback
     */
    public function getSender()
    {
        if (!isset($this->_sender)) {
            $this->setSender(function ($response) {
                Response::processOutgoingResponse($response);
            });
        }
        return $this->_sender;
    }

    /**
     * Send response to the output.
     */
    public function send()
    {
        return $this->getSender()->call($this);
    }

    /**
     * Process response and render output.
     * @param Response $response
     */
    public static function processOutgoingResponse(Response $response)
    {
        header('HTTP/1.1 '.$response->getStatusCode().' '.$response->getStatusMessage());
        foreach ($response->_headers as $name => $value) {
            header($name.': '.$value, true);
        }
        echo $response->_body;
    }

}
