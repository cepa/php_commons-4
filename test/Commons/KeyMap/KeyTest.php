<?php

/**
 * =============================================================================
 * @file        Commons/KeyMap/KeyTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\KeyMap;

class KeyTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetUnique()
    {
        $key = new Key();
        $this->assertNull($key->getUnique());
        $k = $key->setUnique('xxx');
        $this->assertTrue($k instanceof Key);
        $this->assertEquals('xxx', $key->getUnique());
    }
    
    public function testSetGetMap()
    {
        $key = new Key();
        $k = $key->setMap(new Map());
        $this->assertTrue($k instanceof Key);
        $this->assertTrue($key->getMap() instanceof Map);
    }
    
    public function testGetGetMapException()
    {
        $this->setExpectedException('\\Commons\\KeyMap\\Exception');
        $key = new Key();
        $key->getMap();
    }
    
    public function testSetGetType()
    {
        $key = new Key();
        $this->assertNull($key->getType());
        $k = $key->setType('xxx');
        $this->assertTrue($k instanceof Key);
        $this->assertEquals('xxx', $key->getType());
    }
    
    public function testSetGetValue()
    {
        $key = new Key();
        $this->assertNull($key->getValue());
        $k = $key->setValue('xxx');
        $this->assertTrue($k instanceof Key);
        $this->assertEquals('xxx', $key->getValue());
    }
    
    public function testAddHasRemoveLink()
    {
        $key = new Key();
        $this->assertFalse($key->hasLink('xxx'));
        $k = $key->addLink('xxx');
        $this->assertTrue($k instanceof Key);
        $this->assertTrue($key->hasLink('xxx'));
        $k = $key->removeLink('xxx');
        $this->assertTrue($k instanceof Key);
        $this->assertFalse($key->hasLink('xxx'));
    }
    
    public function testSetGetLinks()
    {
        $key = new Key();
        $this->assertEquals(0, count($key->getLinks()));
        $k = $key->setLinks(array('x', 'y', 'z'));
        $this->assertTrue($k instanceof Key);
        $this->assertEquals(3, count($key->getLinks()));
        $this->assertTrue($key->hasLink('y'));
    }
    
    public function testToString()
    {
        $key = new Key();
        $key->setValue('xxx');
        $this->assertEquals('xxx', (string) $key);
    }
    
}
