<?php

/**
 * =============================================================================
 * @file        Commons/Light/Dispatcher/HttpDispatcherTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\Dispatcher;

use Commons\Buffer\OutputBuffer;

use Commons\Light\Route\RouteInterface;
use Commons\Light\Route\StaticRoute;

class HttpDispatcherTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetBaseUri()
    {
        $dispatcher = new HttpDispatcher();
        $this->assertNull($dispatcher->getBaseUri());
        $d = $dispatcher->setBaseUri('test');
        $this->assertTrue($d instanceof HttpDispatcher);
        $this->assertEquals('test', $dispatcher->getBaseUri());
    }
    
    public function testSetGetDefaultModule()
    {
        $dispatcher = new HttpDispatcher();
        $this->assertEquals('default', $dispatcher->getDefaultModule());
        $d = $dispatcher->setDefaultModule('xxx');
        $this->assertTrue($d instanceof HttpDispatcher);
        $this->assertEquals('xxx', $dispatcher->getDefaultModule());
    }
    
    public function testSetGetHasRemoveModuleNamespace()
    {
        $dispatcher = new HttpDispatcher();
        $this->assertFalse($dispatcher->hasModuleNamespace('xxx'));
        $d = $dispatcher->setModuleNamespace('xxx', 'yyy');
        $this->assertTrue($d instanceof HttpDispatcher);
        $this->assertTrue($dispatcher->hasModuleNamespace('xxx'));
        $this->assertEquals('yyy', $dispatcher->getModuleNamespace('xxx'));
        $d = $dispatcher->removeModuleNamespace('xxx');
        $this->assertTrue($d instanceof HttpDispatcher);
        $this->assertFalse($dispatcher->hasModuleNamespace('xxx'));
    }
    
    public function testSetGetClearModuleNamespaces()
    {
        $dispatcher = new HttpDispatcher();
        $this->assertEquals(0, count($dispatcher->getModuleNamespaces()));
        $d = $dispatcher->setModuleNamespaces(array(
            'xxx' => '123',
            'yyy' => '456'
        ));
        $this->assertTrue($d instanceof HttpDispatcher);
        $this->assertEquals(2, count($dispatcher->getModuleNamespaces()));
        $this->assertTrue($dispatcher->hasModuleNamespace('xxx'));
        $this->assertEquals('456', $dispatcher->getModuleNamespace('yyy'));
        $d = $dispatcher->clearModuleNamespaces();
        $this->assertTrue($d instanceof HttpDispatcher);
        $this->assertEquals(0, count($dispatcher->getModuleNamespaces()));
    }
    
    public function testGetModuleNamespaceException()
    {
        $this->setExpectedException('\\Commons\\Light\\Dispatcher\\Exception');
        $dispatcher = new HttpDispatcher();
        $dispatcher->getModuleNamespace('xxx');
    }
    
    public function testSetGetHasRemoveRoute()
    {
        $dispatcher = new HttpDispatcher();
        $this->assertFalse($dispatcher->hasRoute('xxx'));
        $d = $dispatcher->setRoute('xxx', new StaticRoute('test', array()));
        $this->assertTrue($d instanceof HttpDispatcher);
        $this->assertTrue($dispatcher->hasRoute('xxx'));
        $this->assertTrue($dispatcher->getRoute('xxx') instanceof RouteInterface);
        $d = $dispatcher->removeRoute('xxx');
        $this->assertTrue($d instanceof HttpDispatcher);
        $this->assertFalse($dispatcher->hasRoute('xxx'));
    }
    
    public function testAddGetClearRoutes()
    {
        $dispatcher = new HttpDispatcher();
        $this->assertEquals(0, count($dispatcher->getRoutes()));
        $d = $dispatcher->addRoutes(array(
            'x' => new StaticRoute('x', array()),
            'y' => new StaticRoute('y', array())
        ));
        $this->assertTrue($d instanceof HttpDispatcher);
        $this->assertEquals(2, count($dispatcher->getRoutes()));
        $this->assertTrue($dispatcher->hasRoute('x'));
        $this->assertTrue($dispatcher->getRoute('y') instanceof RouteInterface);
        $d = $dispatcher->clearRoutes();
        $this->assertEquals(0, count($dispatcher->getRoutes()));
    }
    
    public function testGetRouteException()
    {
        $this->setExpectedException('\\Commons\\Light\\Dispatcher\\Exception');
        $dispatcher = new HttpDispatcher();
        $dispatcher->getRoute('xxx');
    }
    
    public function testDispatch()
    {
        $dispatcher = new HttpDispatcher();
        
        OutputBuffer::start();
        
        $dispatcher
            ->setDefaultModule('mock')
            ->setModuleNamespace('mock', 'Mock\\Light\\')
            ->dispatch(array('controller' => 'action'));
        
        $contents = OutputBuffer::end();
        $this->assertEquals('layout index action', $contents);
    }
    
}
