<?php

/**
 * =============================================================================
 * @file       Commons/Application/AbstractApplicationTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Application;

use Commons\Log\Logger;
use Commons\Service\ServiceManager;
use Mock\Application as MockApplication;

class AbstractApplicationTest extends \PHPUnit_Framework_TestCase
{
    
    public function testSetGetEnvironment()
    {
        $app = new MockApplication();
        $this->assertNull($app->getEnvironment());
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
    
    public function testSetGetServiceManager()
    {
        $app = new MockApplication();
        $this->assertTrue($app->getServiceManager() instanceof ServiceManager);
    }
        
}
