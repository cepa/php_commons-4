<?php

/**
 * =============================================================================
 * @file       Commons/Service/ManagerTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Service;

use Mock\Service\FooService as MockFooService;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    
    public function testAddHasRemoveNamespace()
    {
        $manager = new Manager();
        $this->assertFalse($manager->hasNamespace('xxx'));
        $b = $manager->addNamespace('xxx');
        $this->assertTrue($b instanceof Manager);
        $this->assertTrue($b->hasNamespace('xxx'));
        $b = $manager->removeNamespace('xxx');
        $this->assertTrue($b instanceof Manager);
        $this->assertFalse($manager->hasNamespace('xxx'));
    }
    
    public function testSetGetNamespaces()
    {
        $manager = new Manager();
        $this->assertEquals(0, count($manager->getNamespaces()));
        $b = $manager->setNamespaces(array('xxx', 'yyy'));
        $this->assertTrue($b instanceof Manager);
        $this->assertEquals(2, count($manager->getNamespaces()));
        $this->assertTrue($manager->hasNamespace('xxx'));
        $this->assertTrue($manager->hasNamespace('yyy'));
        $this->assertFalse($manager->hasNamespace('zzz'));
    }
    
    public function testAddHasGetRemoveService()
    {
        $manager = new Manager();
        $this->assertFalse($manager->hasService('foo'));
        $b = $manager->addService('foo', new MockFooService());
        $this->assertTrue($b instanceof Manager);
        $this->assertTrue($manager->hasService('foo'));
        $this->assertTrue($manager->getService('foo') instanceof ServiceInterface);
        $b = $manager->removeService('foo');
        $this->assertTrue($b instanceof Manager);
        $this->assertFalse($manager->hasService('foo'));
    }
    
}
