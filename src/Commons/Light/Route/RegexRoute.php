<?php

/**
 * =============================================================================
 * @file        Commons/Light/Route/RegexRoute.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\Route;

use Commons\Http\Request;

class RegexRoute implements RouteInterface
{
    
    protected $_matchPattern;
    protected $_params;
    protected $_mappings;
    protected $_assemblyPattern;

    /**
     * @param $matchPattern
     * @param array $params
     * @param array $mappings
     * @param string $assemblyPattern
     */
    public function __construct($matchPattern, array $params = array(), array $mappings = array(), $assemblyPattern = null)
    {
        $this->_matchPattern = $matchPattern;
        $this->_params = $params;
        $this->_mappings = $mappings;
        $this->_assemblyPattern = (isset($assemblyPattern) ? $assemblyPattern : $matchPattern);
    }
    
    /**
     * Match.
     * @see \Commons\Light\Route\RouteInterface::match()
     */
    public function match(Request $request)
    {
        if (preg_match("#^{$this->_matchPattern}$#", $request->getUri(), $matches)) {
            foreach ($this->_mappings as $idx => $key) {
                if (isset($matches[$idx+1])) {
                    $this->_params[$key] = $matches[$idx+1];
                }
            }
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
        $params = array_merge($this->_params, $params);
        $args = array();
        foreach ($this->_mappings as $idx => $key) {
            if (!isset($params[$key])) {
                throw new \Exception("Cannot assembly route, missing route key '{$key}'");
            }
            $args[] = $params[$key];
        }
        return vsprintf($this->_assemblyPattern, $args);
    }
    
}
