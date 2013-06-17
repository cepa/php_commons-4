<?php

/**
 * =============================================================================
 * @file       Commons/Light/Route/StaticRoute.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\Route;

use Commons\Http\Request;

class StaticRoute implements RouteInterface
{
    
    protected $_pattern;
    protected $_params;
    
    /**
     * Init route.
     * @param string $pattern
     * @param array $params
     */
    public function __construct($pattern, array $params = array())
    {
        $this->_pattern = trim($pattern, '/');
        $this->_params = $params;
    }
    
    /**
     * Match.
     * @see \Commons\Light\Route\RouteInterface::match()
     */
    public function match(Request $request)
    {
        if ($request->getUri() == $this->_pattern) {
            return $this->_params;
        }
        return false;
    }
    
    /**
     * Assembly.
     * @see \Commons\Light\Route\RouteInterface::assembly()
     */
    public function assembly(array $params = array())
    {
        $url = $this->_pattern;
        if (count($params) > 0) {
            $url .= '?'.http_build_query($params);
        }
        return $url;
    }
    
}
