<?php

/**
 * =============================================================================
 * @file       Commons/Light/Route/RestRouteTest.php
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

class RestRouteTest extends \PHPUnit_Framework_TestCase
{
   
    public function testMatch_Get()
    {
        $route = new RestRoute('GET', 'user/(.*)', array(), array('user_id'));
        $params = $route->match($this->createRequest('GET', 'user/123'));
        $this->assertTrue(is_array($params));
        $this->assertEquals(123, $params['user_id']);
        
        $this->assertFalse($route->match($this->createRequest('GET', 'xxx')));
        $this->assertFalse($route->match($this->createRequest('GET', '')));
        
        $this->assertFalse($route->match($this->createRequest('POST', 'user/123')));
        $this->assertFalse($route->match($this->createRequest('PUT', 'user/123')));
        $this->assertFalse($route->match($this->createRequest('DELETE', 'user/123')));
    }
    
    public function testMatch_Post()
    {
        $route = new RestRoute('POST', 'user/(.*)', array(), array('user_id'));
        $params = $route->match($this->createRequest('POST', 'user/123'));
        $this->assertTrue(is_array($params));
        $this->assertEquals(123, $params['user_id']);
        
        $this->assertFalse($route->match($this->createRequest('POST', 'xxx')));
        $this->assertFalse($route->match($this->createRequest('POST', '')));
        
        $this->assertFalse($route->match($this->createRequest('GET', 'user/123')));
        $this->assertFalse($route->match($this->createRequest('PUT', 'user/123')));
        $this->assertFalse($route->match($this->createRequest('DELETE', 'user/123')));
    }
    
    public function testMatch_Put()
    {
        $route = new RestRoute('PUT', 'user/(.*)', array(), array('user_id'));
        $params = $route->match($this->createRequest('PUT', 'user/123'));
        $this->assertTrue(is_array($params));
        $this->assertEquals(123, $params['user_id']);
        
        $this->assertFalse($route->match($this->createRequest('PUT', 'xxx')));
        $this->assertFalse($route->match($this->createRequest('PUT', '')));
        
        $this->assertFalse($route->match($this->createRequest('GET', 'user/123')));
        $this->assertFalse($route->match($this->createRequest('POST', 'user/123')));
        $this->assertFalse($route->match($this->createRequest('DELETE', 'user/123')));
    }
    
    public function testMatch_Delete()
    {
        $route = new RestRoute('DELETE', 'user/(.*)', array(), array('user_id'));
        $params = $route->match($this->createRequest('DELETE', 'user/123'));
        $this->assertTrue(is_array($params));
        $this->assertEquals(123, $params['user_id']);
        
        $this->assertFalse($route->match($this->createRequest('DELETE', 'xxx')));
        $this->assertFalse($route->match($this->createRequest('DELETE', '')));
        
        $this->assertFalse($route->match($this->createRequest('GET', 'user/123')));
        $this->assertFalse($route->match($this->createRequest('POST', 'user/123')));
        $this->assertFalse($route->match($this->createRequest('PUT', 'user/123')));
    }
    
    public function createRequest($method, $uri)
    {
    	$request = new Request();
    	$request
    	    ->setMethod($method)
    	    ->setUri($uri);
    	return $request;
    }
    
}
