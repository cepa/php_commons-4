<?php

/**
 * =============================================================================
 * @file        Commons/Application/AbstractApplicationTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Application;

use Commons\Log\Logger;
use Mock\Application as MockApplication;

class AbstractApplicationTest extends \PHPUnit_Framework_TestCase
{
    
    public function testSetGetEnvironment()
    {
        $app = new MockApplication();
        $this->assertEquals('development', $app->getEnvironment());
        $a = $app->setEnvironment('testing');
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertEquals('testing', $app->getEnvironment());
    }
    
    public function testSetGetVersion()
    {
        $app = new MockApplication();
        $this->assertNull($app->getVersion());
        $a = $app->setVersion('1.2.3');
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertEquals('1.2.3', $app->getVersion());
    }
    
    public function testSetGetPath()
    {
        $app = new MockApplication();
        $this->assertNull($app->getPath());
        $a = $app->setPath('/path');
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertEquals('/path', $app->getPath());
    }
    
    public function testSetGetConfig()
    {
        $app = new MockApplication();
        $this->assertNull($app->getConfig());
        $a = $app->setConfig(array());
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertTrue(is_array($app->getConfig()));
    }
    
    public function testSetGetClearModules()
    {
        $app = new MockApplication();
        $this->assertTrue(is_array($app->getModules()));
        $this->assertEquals(0, count($app->getModules()));
        $a = $app->setModules(array('xxx' => 'xxx'));
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertEquals(1, count($app->getModules()));
        $a = $app->clearModules();
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertEquals(0, count($app->getModules()));
    }
    
    public function testAddGetHasRemoveModule()
    {
        $app = new MockApplication();
        $this->assertFalse($app->hasModule('xxx'));
        $a = $app->addModule('xxx');
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertTrue($app->hasModule('xxx'));
        $a = $app->addModule('yyy', 666);
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertTrue($app->hasModule('yyy'));
        $this->assertEquals(666, $app->getModule('yyy'));
        $a = $app->removeModule('xxx');
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertFalse($app->hasModule('xxx'));
        $this->assertTrue($app->hasModule('yyy'));
    }
    
    public function testSetGetClearProperties()
    {
        $app = new MockApplication();
        $this->assertTrue(is_array($app->getProperties()));
        $this->assertEquals(0, count($app->getProperties()));
        $a = $app->setProperties(array('xxx' => 'xxx'));
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertEquals(1, count($app->getProperties()));
        $a = $app->clearProperties();
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertEquals(0, count($app->getProperties()));
    }
    
    public function testSetGetHasRemoveProperty()
    {
        $app = new MockApplication();
        $this->assertFalse($app->hasProperty('xxx'));
        $a = $app->setProperty('xxx', 123);
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertTrue($app->hasProperty('xxx'));
        $a = $app->setProperty('yyy', 666);
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertTrue($app->hasProperty('yyy'));
        $this->assertEquals(666, $app->getProperty('yyy'));
        $a = $app->removeProperty('xxx');
        $this->assertTrue($a instanceof AbstractApplication);
        $this->assertFalse($app->hasProperty('xxx'));
        $this->assertTrue($app->hasProperty('yyy'));
    }
    
}
