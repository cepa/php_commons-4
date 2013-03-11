<?php

/**
 * =============================================================================
 * @file        Commons/Light/Module/AbstractModuleTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\Module;

use Commons\Light\Application\AbstractApplication;
use Mock\Light\Application as MockApplication;
use Mock\Light\Module as MockModule;

class AbstractModuleTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetApplication()
    {
        $module = new MockModule();
        $this->assertNull($module->getApplication());
        $m = $module->setApplication(new MockApplication());
        $this->assertTrue($m instanceof AbstractModule);
        $this->assertTrue($module->getApplication() instanceof AbstractApplication);
    }
    
    public function testModuleNameToClassName()
    {
        $this->assertEquals('Module', AbstractModule::moduleNameToClassName('module'));
        $this->assertEquals('SomeUsefulModule', AbstractModule::moduleNameToClassName('some-useful-module'));
    }
    
}
