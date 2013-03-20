<?php

/**
 * =============================================================================
 * @file        Commons/Light/Dispatcher/AbstractDispatcherTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\Dispatcher;

use Commons\Http\Response;
use Commons\Http\Request;
use Commons\Light\Route\RouteInterface;
use Commons\Light\Route\StaticRoute;
use Mock\Light\Dispatcher as MockDispatcher;

class AbstractDispatcherTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetRequest()
    {
        $controller = new MockDispatcher();
        $this->assertTrue($controller->getRequest() instanceof Request);
        $c = $controller->setRequest(new Request());
        $this->assertTrue($c instanceof AbstractDispatcher);
        $this->assertTrue($controller->getRequest() instanceof Request);
    }
    
    public function testSetGetResponse()
    {
        $controller = new MockDispatcher();
        $this->assertTrue($controller->getResponse() instanceof Response);
        $c = $controller->setResponse(new Response());
        $this->assertTrue($c instanceof AbstractDispatcher);
        $this->assertTrue($controller->getResponse() instanceof Response);
    }
    
    public function testSetGetHasRemoveRoute()
    {
        $dispatcher = new MockDispatcher();
        $this->assertFalse($dispatcher->hasRoute('xxx'));
        $d = $dispatcher->setRoute('xxx', new StaticRoute('test', array()));
        $this->assertTrue($d instanceof MockDispatcher);
        $this->assertTrue($dispatcher->hasRoute('xxx'));
        $this->assertTrue($dispatcher->getRoute('xxx') instanceof RouteInterface);
        $d = $dispatcher->removeRoute('xxx');
        $this->assertTrue($d instanceof MockDispatcher);
        $this->assertFalse($dispatcher->hasRoute('xxx'));
    }
    
    public function testAddGetClearRoutes()
    {
        $dispatcher = new MockDispatcher();
        $this->assertEquals(0, count($dispatcher->getRoutes()));
        $d = $dispatcher->addRoutes(array(
            'x' => new StaticRoute('x', array()),
            'y' => new StaticRoute('y', array())
        ));
        $this->assertTrue($d instanceof MockDispatcher);
        $this->assertEquals(2, count($dispatcher->getRoutes()));
        $this->assertTrue($dispatcher->hasRoute('x'));
        $this->assertTrue($dispatcher->getRoute('y') instanceof RouteInterface);
        $d = $dispatcher->clearRoutes();
        $this->assertEquals(0, count($dispatcher->getRoutes()));
    }
    
    public function testGetRouteException()
    {
        $this->setExpectedException('\\Commons\\Light\\Dispatcher\\Exception');
        $dispatcher = new MockDispatcher();
        $dispatcher->getRoute('xxx');
    }
    
}
