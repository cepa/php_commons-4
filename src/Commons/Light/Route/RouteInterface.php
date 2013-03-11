<?php

/**
 * =============================================================================
 * @file        Commons/Light/Route/RouteInterface.php
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

interface RouteInterface
{
    
    /**
     * Match route to given request.
     * @param string $uri
     * @return array
     */
    public function match(Request $request);
    
    /**
     * Assembly route.
     * @param array $params
     * @return string
     */
    public function assembly(array $params = array());
    
}
