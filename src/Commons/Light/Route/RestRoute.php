<?php

/**
 * =============================================================================
 * @file       Commons/Light/Route/RestRoute.php
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

class RestRoute extends RegexRoute
{

	protected $_method;

    public function __construct($method, $matchPattern, array $params = array(), array $mappings = array(), $assemblyPattern = null)
    {
    	parent::__construct($matchPattern, $params, $mappings, $assemblyPattern);
    	$this->_method = $method;
    }

    /**
     * @param Request $request
     * @return array|false
     */
    public function match(Request $request)
    {
    	if (empty($this->_method) || $request->getMethod() == $this->_method) {
    		return parent::match($request);
    	}
    	return false;
    }

}
