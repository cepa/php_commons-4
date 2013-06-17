<?php

/**
 * =============================================================================
 * @file       Commons/Container/SetContainerTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Container;

class SetContainerTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $set = new SetContainer();
        $this->assertEquals(0, count($set));
    }
    
    public function testConstructWithArray()
    {
        $set = new SetContainer(array(1, 2, 3));
        $this->assertEquals(3, count($set));
    }
       
    public function testAddSetGetHasRemoveSetElement()
    {
        $set = new SetContainer(array(123, 456));
        $this->assertEquals(2, count($set));
        
        $this->assertTrue(isset($set[0]));
        $this->assertTrue($set->has(0));
        
        $this->assertTrue(isset($set[1]));
        $this->assertTrue($set->has(1));
        
        $this->assertFalse(isset($set[2]));
        $this->assertFalse($set->has(2));
        
        $s = $set->add(789);
        $this->assertTrue($s instanceof SetContainer);
        $this->assertEquals(3, count($set));
        $this->assertTrue(isset($set[2]));
        $this->assertTrue($set->has(2));
        $this->assertEquals(789, $set[2]);
        $this->assertEquals(789, $set->get(2));
        
        $s = $set->set(1, 'xyz');
        $this->assertTrue($s instanceof SetContainer);
        $this->assertEquals('xyz', $s[1]);
        $this->assertEquals('xyz', $s->get(1));
        
        $s = $set->remove(1);
        $this->assertTrue($s instanceof SetContainer);
        $this->assertEquals(2, count($set));
        $this->assertFalse(isset($set[1]));
        $this->assertFalse($set->has(1));
    }
    
    public function testArrayAccessNullIndex()
    {
        $set = new SetContainer();
        $set[] = 123;
        $set[] = 456;
        $set[] = 789;
        $this->assertEquals(3, count($set));
    }
    
}
