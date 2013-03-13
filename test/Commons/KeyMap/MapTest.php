<?php

/**
 * =============================================================================
 * @file        Commons/KeyMap/MapTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\KeyMap;

use Mock\KeyStore as MockKeyStore;

class MapTest extends \PHPUnit_Framework_TestCase
{
    
    public function testScenario()
    {
        $map = new Map();
        $map->setKeyStore(new MockKeyStore());
        
        $a = $map->findOrCreate('a')->setValue('this is key a')->save();
        $b = $map->findOrCreate('b')->setValue('this is key b')->save();
        $c = $map->findOrCreate('c')->setValue('this is key c')->save();
        $d = $map->findOrCreate('d')->setValue('this is key d')->save();
        
        $this->assertTrue($map->has('a'));
        $this->assertTrue($map->has('b'));
        $this->assertTrue($map->has('c'));
        $this->assertTrue($map->has('d'));
        
        $map->findOrCreate('x')->setValue('this is keyspace x')
            ->addLink($a->getUnique())
            ->addLink($b->getUnique())
            ->addLink($c->getUnique())
            ->save();
        $this->assertTrue($map->has('x'));
        
        $links = $map->find('x')->getLinks();
        $this->assertEquals(3, count($links));
        $this->assertEquals('a', $links['a']);
        $this->assertEquals('b', $links['b']);
        $this->assertEquals('c', $links['c']);
        
        $map->find('x')->delete();
        $this->assertFalse($map->has('x'));
        $this->assertFalse($map->has('a'));
        $this->assertFalse($map->has('b'));
        $this->assertFalse($map->has('c'));
        $this->assertTrue($map->has('d'));
    }

}
