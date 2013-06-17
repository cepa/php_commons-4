<?php

/**
 * =============================================================================
 * @file       Commons/Container/AssocContainerTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Container;

class AssocContainerTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $assoc = new AssocContainer();
        $this->assertEquals(0, count($assoc));
    }
    
    public function testConstructWithArray()
    {
        $assoc = new AssocContainer(array(1, 2, 3));
        $this->assertEquals(3, count($assoc));
    }
    
    public function testSetGetHasRemoveCollectionContainerElement()
    {
        $assoc = new AssocContainer(array('xyz' => 123));
        
        $this->assertFalse($assoc->has('abc'));
        $this->assertFalse(isset($assoc->abc));
        $this->assertFalse(isset($assoc['abc']));
        
        $this->assertTrue($assoc->has('xyz'));
        $this->assertTrue(isset($assoc->xyz));
        $this->assertTrue(isset($assoc['xyz']));
        
        $this->assertEquals(123, $assoc->get('xyz'));
        $this->assertEquals(123, $assoc->xyz);
        $this->assertEquals(123, $assoc['xyz']);
        
        $c = $assoc->set('abc', 666);
        $this->assertTrue($c instanceof AssocContainer);
        
        $this->assertTrue($assoc->has('abc'));
        $this->assertTrue(isset($assoc->abc));
        $this->assertTrue(isset($assoc['abc']));
        
        $this->assertEquals(666, $assoc->get('abc'));
        $this->assertEquals(666, $assoc->abc);
        $this->assertEquals(666, $assoc['abc']);
        
        $c = $assoc->set('xyz', 321);
        $this->assertTrue($c instanceof AssocContainer);

        $this->assertTrue($assoc->has('xyz'));
        $this->assertTrue(isset($assoc->xyz));
        $this->assertTrue(isset($assoc['xyz']));
        
        $this->assertEquals(321, $assoc->get('xyz'));
        $this->assertEquals(321, $assoc->xyz);
        $this->assertEquals(321, $assoc['xyz']);
        
        $this->assertEquals(2, count($assoc));
        
        $c = $assoc->remove('xyz');
        $this->assertTrue($c instanceof AssocContainer);
        
        $this->assertEquals(1, count($assoc));
        
        $this->assertFalse($assoc->has('xyz'));
        $this->assertFalse(isset($assoc->xyz));
        $this->assertFalse(isset($assoc['xyz']));
        
        $this->assertTrue($assoc->has('abc'));
        $this->assertTrue(isset($assoc->abc));
        $this->assertTrue(isset($assoc['abc']));
        
        $assoc->test = 'testing';
        $this->assertTrue(isset($assoc->test));
        $this->assertEquals('testing', $assoc->test);
        unset($assoc->test);
        $this->assertFalse(isset($assoc->test));
        
        $assoc['test'] = 'testing';
        $this->assertTrue(isset($assoc['test']));
        $this->assertEquals('testing', $assoc['test']);
        unset($assoc['test']);
        $this->assertFalse(isset($assoc['test']));
    }
    
}
