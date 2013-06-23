<?php

/**
 * =============================================================================
 * @file       Commons/Service/ServiceManagerTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Service;

use Mock\Service\TestService as MockTestService;

class ServiceManagerTest extends \PHPUnit_Framework_TestCase
{
    
    public function testAddHasGetRemoveFactory()
    {
        $manager = new ServiceManager();
        $this->assertFalse($manager->hasFactory('xxx'));
        $m = $manager->addFactory('xxx', function(){});
        $this->assertTrue($m instanceof ServiceManager);
        $this->assertTrue($manager->hasFactory('xxx'));
        $this->assertTrue(is_callable($manager->getFactory('xxx')));
        $m = $manager->removeFactory('xxx');
        $this->assertTrue($m instanceof ServiceManager);
        $this->assertFalse($manager->hasFactory('xxx'));
    }
    
    public function testGetFactoryException()
    {
        $this->setExpectedException('\Commons\Service\Exception');
        $manager = new ServiceManager();
        $manager->getFactory('xxx');
    }
    
    public function testSetGetFactories()
    {
        $manager = new ServiceManager();
        $this->assertEquals(0, count($manager->getFactories()));
        $m = $manager->setFactories(array(
            'xxx' => function(){},
            'yyy' => function(){}
        ));
        $this->assertTrue($m instanceof ServiceManager);
        $this->assertEquals(2, count($manager->getFactories()));
    }
    
    public function testSetGetHasRemoveService()
    {
        $manager = new ServiceManager();
        $this->assertFalse($manager->hasService('xxx'));
        $m = $manager->setService('xxx', $this->getMock('\Commons\Service\ServiceInterface'));
        $this->assertTrue($m instanceof ServiceManager);
        $this->assertTrue($manager->hasService('xxx'));
        $m = $manager->removeService('xxx');
        $this->assertTrue($m instanceof ServiceManager);
        $this->assertFalse($manager->hasService('xxx'));
    }
    
    public function testGetServiceException()
    {
        $this->setExpectedException('\Commons\Service\Exception');
        $manager = new ServiceManager();
        $manager->getService('xxx');
    }
    
    public function testSetGetServices()
    {
        $manager = new ServiceManager();
        $this->assertEquals(0, count($manager->getServices()));
        $this->assertFalse($manager->hasService('xxx'));
        $m = $manager->setServices(array(
            'xxx' => $this->getMock('\Commons\Service\ServiceInterface'),
            'yyy' => $this->getMock('\Commons\Service\ServiceInterface')
        ));
        $this->assertTrue($m instanceof ServiceManager);
        $this->assertEquals(2, count($manager->getServices()));
        $this->assertTrue($manager->hasService('xxx'));
    }
    
    public function testCreateServiceByClosureFactory()
    {
        $test = $this;
        $manager = new ServiceManager();
        $manager->addFactory('Foo', function() use($test){
            return $test->getMock('\Commons\Service\ServiceInterface');
        });
        $service = $manager->getService('Foo');
        $this->assertTrue($service instanceof ServiceInterface);
    }
    
    public function testServiceDependencyInjection()
    {
        $manager = new ServiceManager();
        $manager
            ->addFactory('Foo', function(){ return new MockTestService('Foo'); })
            ->addFactory('Poo', function(){ return new MockTestService('Poo'); });
        $foo = $manager->getService('Foo');
        $this->assertEquals('Foo', $foo->getName());
        $poo = $foo->getServiceManager()->getService('Poo');
        $this->assertEquals('Poo', $poo->getName());
    }
    
}
