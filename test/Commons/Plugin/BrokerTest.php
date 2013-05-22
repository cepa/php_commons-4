<?php

/**
 * =============================================================================
 * @file        Commons/Plugin/BrokerTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Plugin;

use Mock\Plugin\Extendable as MockExtendable;
use Mock\Plugin\FooPlugin as MockFooPlugin;

class BrokerTest extends \PHPUnit_Framework_TestCase
{
    
    public function testAddHasRemoveNamespace()
    {
        $broker = new Broker();
        $this->assertFalse($broker->hasNamespace('xxx'));
        $b = $broker->addNamespace('xxx');
        $this->assertTrue($b instanceof Broker);
        $this->assertTrue($b->hasNamespace('xxx'));
        $b = $broker->removeNamespace('xxx');
        $this->assertTrue($b instanceof Broker);
        $this->assertFalse($broker->hasNamespace('xxx'));
    }
    
    public function testSetGetNamespaces()
    {
        $broker = new Broker();
        $this->assertEquals(0, count($broker->getNamespaces()));
        $b = $broker->setNamespaces(array('xxx', 'yyy'));
        $this->assertTrue($b instanceof Broker);
        $this->assertEquals(2, count($broker->getNamespaces()));
        $this->assertTrue($broker->hasNamespace('xxx'));
        $this->assertTrue($broker->hasNamespace('yyy'));
        $this->assertFalse($broker->hasNamespace('zzz'));
    }
    
    public function testAddHasGetRemovePlugin()
    {
        $broker = new Broker();
        $this->assertFalse($broker->hasPlugin('foo'));
        $b = $broker->addPlugin('foo', new MockFooPlugin());
        $this->assertTrue($b instanceof Broker);
        $this->assertTrue($broker->hasPlugin('foo'));
        $this->assertTrue($broker->getPlugin('foo') instanceof PluginInterface);
        $this->assertEquals('test', $broker->invoke('foo', new MockExtendable(), array('test')));
        $b = $broker->removePlugin('foo');
        $this->assertTrue($b instanceof Broker);
        $this->assertFalse($broker->hasPlugin('foo'));
    }
    
    public function testInvoke()
    {
        $extendable = new MockExtendable();
        $this->assertEquals('xxx', $extendable->foo('xxx'));
    }
    
    public function testInvokePluginNotFoundException()
    {
        $this->setExpectedException('\Commons\Plugin\Exception');
        $extendable = new MockExtendable();
        $this->assertEquals('xxx', $extendable->xxx('xxx'));
    }
    
}
