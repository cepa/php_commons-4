<?php

/**
 * =============================================================================
 * @file        Commons/Template/Plugin/BaseUrlPlugin.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Template\Plugin;

use Commons\Http\Request;
use Commons\Plugin\ExtendableInterface;
use Commons\Plugin\PluginInterface;

class BaseUrlPlugin implements PluginInterface
{
    
    protected $_baseUrl;
    
    /**
     * Set base url.
     * @param string $baseUrl
     * @return \Commons\Template\Plugin\BaseUrlPlugin
     */
    public function setBaseUrl($baseUrl)
    {
        $this->_baseUrl = $baseUrl;
        return $this;
    }
    
    /**
     * Get base url.
     * @return string
     */
    public function getBaseUrl()
    {
        if (!isset($this->_baseUrl)) {
            $proto = 'http';
            if ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') 
                    || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) {
                $proto = 'https';
            }
            $host = (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '127.0.0.1');
            $baseUri = Request::extractBaseUri();
            $this->setBaseUrl($proto.'://'.$host.$baseUri);
        }
        return $this->_baseUrl;
    }
    
    /**
     * 
     * @see \Commons\Plugin\PluginInterface::invoke()
     */
    public function invoke(ExtendableInterface $invoker, array $args = array())
    {
        return $this->getBaseUrl();
    }
    
}

