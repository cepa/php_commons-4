<?php

/**
 * =============================================================================
 * @file       Commons/Light/Route/RegexRouteTest.php
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

class RegexRouteTest extends \PHPUnit_Framework_TestCase
{
   
    public function testMatch_Default()
    {
        $route = new RegexRoute('index.html');
        $this->assertTrue(is_array($route->match($this->createRequest('index.html'))));
        
        $this->assertFalse($route->match($this->createRequest('xxx')));
        $this->assertFalse($route->match($this->createRequest('')));
    }
    
    public function testMatch_Assembly()
    {
        $route = new RegexRoute('index.html');
        $this->assertEquals('index.html', $route->assembly());
    }
    
    public function testMatch_Regex()
    {
        $route = new RegexRoute(
            'category/([0-9]+)/item/([a-zA-Z0-9\-]+)',
            array('action' => 'show', 'controller' => 'item', 'module' => 'store'),
            array('category_id', 'item_slug'),
            'category/%d/item/%s');
        
        $params = $route->match($this->createRequest('category/123/item/some-Great-item666'));
        $this->assertTrue(is_array($params));
        $this->assertEquals('store', $params['module']);
        $this->assertEquals('item', $params['controller']);
        $this->assertEquals('show', $params['action']);
        $this->assertEquals('123', $params['category_id']);
        $this->assertEquals('some-Great-item666', $params['item_slug']);
        
        $this->assertFalse($route->match($this->createRequest('category/1x3/item/some-great-item666')));
        $this->assertFalse($route->match($this->createRequest('category/123/item/some-Great-item666/')));
        $this->assertFalse($route->match($this->createRequest('category/123/item/some-Great-item666.html')));
    }
    
    public function testMatch_AssemblyRegex()
    {
        $route = new RegexRoute(
            'category/([0-9]+)/item/([a-zA-Z0-9\-]+)',
            array('action' => 'show', 'controller' => 'item', 'module' => 'store'),
            array('category_id', 'item_slug'),
            'category/%d/item/%s');
        $this->assertEquals(
            'category/666/item/a-good-item-123',
            $route->assembly(array('category_id' => 666, 'item_slug' => 'a-good-item-123')));
    }
    
    public function createRequest($uri)
    {
    	$request = new Request();
    	$request->setUri($uri);
    	return $request;
    }
    
}
