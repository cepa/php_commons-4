<?php

/**
 * =============================================================================
 * @file        Commons/Container/TraversableContainerTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Container;

class TraversableContainerTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $trv = new TraversableContainer();
        $this->assertEquals('', $trv->getName());
        $this->assertEquals(0, count($trv));
        $this->assertEquals('', $trv->getData());
    }
    
    public function testConstructWithName()
    {
        $trv = new TraversableContainer('abc');
        $this->assertEquals('abc', $trv->getName());
        $this->assertEquals(0, count($trv));
        $this->assertEquals('', $trv->getData());
    }
    
    public function testGetSetName()
    {
        $trv = new TraversableContainer();
        $this->assertEquals('', $trv->getName());
        $t = $trv->setName('xxx');
        $this->assertTrue($t instanceof TraversableContainer);
        $this->assertEquals('xxx', $trv->getName());
    }
    
    public function testSetGetData()
    {
        $trv = new TraversableContainer();
        $this->assertEquals('', $trv->getData());
        $t = $trv->setData('xxx');
        $this->assertTrue($t instanceof TraversableContainer);
        $this->assertEquals('xxx', $trv->getData());
    }
    
    public function testAddSetGetHasRemoveChildAndClear()
    {
        $trv = new TraversableContainer();
        $this->assertEquals(0, count($trv));
        
        // child1
        $t = $trv->addChild(new TraversableContainer('child1'));
        $this->assertTrue($t instanceof TraversableContainer);
        $this->assertEquals(1, count($trv));
        
        $this->assertTrue($trv->hasChild('child1'));
        $this->assertTrue(isset($trv->child1));
        $this->assertTrue(isset($trv['child1']));
        
        $this->assertEquals('child1', $trv->getChild('child1')->getName());
        $this->assertEquals('child1', $trv->child1->getName());
        $this->assertEquals('child1', $trv['child1']->getName());
        
        // child2
        $t = $trv->addChild(new TraversableContainer('child2'));
        $this->assertTrue($t instanceof TraversableContainer);
        $this->assertEquals(2, count($trv));
        
        $this->assertTrue($trv->hasChild('child2'));
        $this->assertTrue(isset($trv->child2));
        $this->assertTrue(isset($trv['child2']));
        
        $this->assertEquals('child2', $trv->getChild('child2')->getName());
        $this->assertEquals('child2', $trv->child2->getName());
        $this->assertEquals('child2', $trv['child2']->getName());
        
        // child3
        $t = $trv->setChild(new TraversableContainer('child3'));
        $this->assertTrue($t instanceof TraversableContainer);
        $this->assertEquals(3, count($trv));
        
        $this->assertTrue($trv->hasChild('child3'));
        $this->assertTrue(isset($trv->child3));
        $this->assertTrue(isset($trv['child3']));
        
        $this->assertEquals('child3', $trv->getChild('child3')->getName());
        $this->assertEquals('child3', $trv->child3->getName());
        $this->assertEquals('child3', $trv['child3']->getName());
        
        // child1 reset
        $child = new TraversableContainer('child1');
        $child->setData('abc');
        
        $t = $trv->setChild($child);
        $this->assertTrue($t instanceof TraversableContainer);
        $this->assertEquals(3, count($trv));
        $this->assertEquals('abc', $trv->child1->getData());
        
        // child1 add second and third
        $trv
            ->addChild(new TraversableContainer('child1'))
            ->addChild(new TraversableContainer('child1'));
        $this->assertEquals(5, count($trv));
        
        // check if the last one has not been overiden
        $this->assertEquals('abc', $trv->child1->getData());
        
        $t = $trv->removeChild('child1');
        $this->assertTrue($t instanceof TraversableContainer);
        
        // only the first child1 was removed
        $this->assertEquals(4, count($trv));
        
        // the assignment is released
        $this->assertFalse($trv->hasChild('child1'));
        
        // clear
        $t = $trv->clear();
        $this->assertTrue($t instanceof TraversableContainer);
        $this->assertEquals(0, count($trv));
    }
    
    public function testTraversableContainerAccess()
    {
        $t = new TraversableContainer();
        
        $t->x = new TraversableContainer();
        $t->x->y = new TraversableContainer();
        $t->x->y->z = new TraversableContainer();
        
        $t->x->y->z->setData('test');
        
        $this->assertEquals('test', $t->x->y->z);
    }
    
    public function testAlter()
    {
        $trv1 = new TraversableContainer();
        $trv1->a = new TraversableContainer();
        $trv1->a->x1 = new TraversableContainer();
        $trv1->a->y1 = new TraversableContainer();
        $trv1->b = new TraversableContainer();
        $trv1->b->x2 = new TraversableContainer();
        $trv1->b->y2 = new TraversableContainer();
        $trv1->c = 'xyz';
        
        $trv2 = new TraversableContainer();
        $trv2->a = new TraversableContainer();
        $trv2->a->x3 = new TraversableContainer();
        $trv2->a->y3 = new TraversableContainer();
        $trv2->b = new TraversableContainer();
        $trv2->b->x4 = new TraversableContainer();
        $trv2->b->y4 = new TraversableContainer();
        $trv2->c = 'zyx';
        $trv2->a->x1 = 'abc';
        $trv2->b->y2 = 'def';
        
        $trv1->alter($trv2);
        
        $this->assertTrue(isset($trv1->a->x1));
        $this->assertTrue(isset($trv1->a->y1));
        $this->assertTrue(isset($trv1->b->x2));
        $this->assertTrue(isset($trv1->b->x2));
        
        $this->assertTrue(isset($trv1->a->x3));
        $this->assertTrue(isset($trv1->a->y3));
        $this->assertTrue(isset($trv1->b->x4));
        $this->assertTrue(isset($trv1->b->x4));
        
        $this->assertEquals('zyx', (string) $trv1->c);
        $this->assertEquals('abc', (string) $trv1->a->x1);
        $this->assertEquals('def', (string) $trv1->b->y2);
    }
    
    public function testCopy()
    {
        $trv1 = new TraversableContainer();
        $trv1->a = new TraversableContainer();
        $trv1->a->x1 = new TraversableContainer();
        $trv1->a->y1 = new TraversableContainer();
        $trv1->b = new TraversableContainer();
        $trv1->b->x2 = new TraversableContainer();
        $trv1->b->y2 = new TraversableContainer();
        $trv1->c = 'xyz';
        
        $trv2 = new TraversableContainer();
        $trv2->a = new TraversableContainer();
        $trv2->a->x3 = new TraversableContainer();
        $trv2->a->y3 = new TraversableContainer();
        $trv2->b = new TraversableContainer();
        $trv2->b->x4 = new TraversableContainer();
        $trv2->b->y4 = new TraversableContainer();
        $trv2->c = 'zyx';
        
        $trv1->copy($trv2);
        
        $this->assertFalse(isset($trv1->a->x1));
        $this->assertFalse(isset($trv1->a->y1));
        $this->assertFalse(isset($trv1->b->x2));
        $this->assertFalse(isset($trv1->b->x2));
        
        $this->assertTrue(isset($trv1->a->x3));
        $this->assertTrue(isset($trv1->a->y3));
        $this->assertTrue(isset($trv1->b->x4));
        $this->assertTrue(isset($trv1->b->x4));
        
        $this->assertEquals('zyx', (string) $trv1->c);
    }
    
}
