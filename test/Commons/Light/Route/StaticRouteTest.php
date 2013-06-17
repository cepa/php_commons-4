<?php

/**
 * =============================================================================
 * @file       Commons/Light/Route/StaticRouteTest.php
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

class StaticRouteTest extends \PHPUnit_Framework_TestCase
{
   
    public function testRoute()
    {
        $route = new StaticRoute('test.html', array('module' => 'test', 'controller' => 'x', 'action' => 'y'));
        $this->assertEquals(3, count($route->match($this->createRequest('test.html'))));
        $this->assertFalse($route->match($this->createRequest('test.htmlx')));
        $this->assertFalse($route->match($this->createRequest('test.htm')));
        $this->assertEquals('test.html', $route->assembly());
        $this->assertEquals('test.html?x=123&b=456', $route->assembly(array('x' => 123, 'b' => 456)));
    }
    
    public function createRequest($uri)
    {
    	$request = new Request();
    	$request->setUri($uri);
    	return $request;
    }
    
}
