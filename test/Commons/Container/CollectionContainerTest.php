<?php

/**
 * =============================================================================
 * @file       Commons/Container/CollectionContainerTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Container;

class CollectionContainerTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $collection = new CollectionContainer();
        $this->assertEquals(0, count($collection));
    }
    
    public function testConstructWithArray()
    {
        $collection = new CollectionContainer(array(1, 2, 3));
        $this->assertEquals(3, count($collection));
    }
    
    public function testSetGetClearCollectionContainer()
    {
        $collection = new CollectionContainer();
        $this->assertEquals(0, count($collection->getAll()));
        
        $c = $collection->setAll(array(1, 2, 3));
        $this->assertTrue($c instanceof CollectionContainer);
        $this->assertEquals(3, count($collection->getAll()));
        $this->assertEquals(3, count($collection));
        
        $c = $collection->clearAll();
        $this->assertTrue($c instanceof CollectionContainer);
        $this->assertEquals(0, count($collection->getAll()));
        $this->assertEquals(0, count($collection));
    }
    
    public function testSetGetHasRemoveCollectionContainerElement()
    {
        $collection = new CollectionContainer();
        $this->assertEquals(0, count($collection));
        
        $c = $collection->set('a', 'xyz');
        $this->assertTrue($c instanceof CollectionContainer);
        $this->assertEquals(1, count($collection));
        $this->assertTrue(isset($collection['a']));
        $this->assertTrue($collection->has('a'));
        $this->assertEquals('xyz', $collection['a']);
        $this->assertEquals('xyz', $collection->get('a'));
        
        $c = $collection->remove('a');
        $this->assertTrue($c instanceof CollectionContainer);
        $this->assertEquals(0, count($collection));
        $this->assertFalse(isset($collection['a']));
        $this->assertFalse($collection->has('a'));
        
        $c = $collection->set('x', null);
        $this->assertTrue($c instanceof CollectionContainer);
        $this->assertFalse($c->has('x'));
        $this->assertNull($c->get('x'));
    }
    
    public function testToString()
    {
        $collection = new CollectionContainer(array('abc' => 123));
        $this->assertContains("'abc' => 123", (string) $collection);
    }
    
    public function testSerialization()
    {
        $a = new CollectionContainer(array('abc' => 123, 'def' => 456));
        $str = $a->serialize();
        
        $b = new CollectionContainer();
        $b->unserialize($str);
        
        $this->assertEquals(123, $b->get('abc'));
        $this->assertEquals(456, $b->get('def'));
    }
    
    public function testIterator()
    {
        $collection = new CollectionContainer(array(1, 2, 3));
        $result = 0;
        foreach ($collection as $i) {
            $result += $i;
        }
        $this->assertEquals(6, $result);
    }
    
    public function testPopulateCollection()
    {
        $x = new CollectionContainer(array('a' => 123, 'b' => 456, 'c' => 789));
        $y = new CollectionContainer($x);
        $this->assertEquals(3, count($y));
        $this->assertEquals(123, $y['a']);
        $this->assertEquals(456, $y['b']);
        $this->assertEquals(789, $y['c']);
    }
    
}
