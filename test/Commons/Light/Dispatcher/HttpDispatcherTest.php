<?php

/**
 * =============================================================================
 * @file       Commons/Light/Dispatcher/HttpDispatcherTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\Dispatcher;

use Commons\Buffer\OutputBuffer;

class HttpDispatcherTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetBaseUri()
    {
        $_SERVER['SCRIPT_NAME'] = '/test/foo.php';
        $dispatcher = new HttpDispatcher();
        $this->assertEquals('/test', $dispatcher->getBaseUri());
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
