<?php

/**
 * =============================================================================
 * @file        Commons/Migration/MapTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Migration;

class MapTest extends \PHPUnit_Framework_TestCase
{
    
    public function testSetHasGetRemoveMigration()
    {
        $map = new Map();
        $this->assertFalse($map->hasMigration(123));
        $m = $map->setMigration(123, 'SomeMigration');
        $this->assertTrue($m instanceof Map);
        $this->assertTrue($map->hasMigration(123));
        $this->assertEquals('SomeMigration', $map->getMigration(123));
        $m = $map->removeMigration(123);
        $this->assertTrue($m instanceof Map);
        $this->assertFalse($map->hasMigration(123));
    }
    
    public function testGetMigration_NotFoundException()
    {
        $this->setExpectedException('\\Commons\\Exception\\NotFoundException');
        $map = new Map();
        $map->getMigration(123);
    }
    
    public function testSetGetClearMigrations()
    {
        $map = new Map();
        $this->assertEquals(0, count($map->getMigrations()));
        $m = $map->setMigrations(array(1 => 'a', 2 => 'b', 3 => 'c'));
        $this->assertTrue($m instanceof Map);
        $this->assertEquals(3, count($map->getMigrations()));
        $this->assertTrue($map->hasMigration(1));
        $this->assertTrue($map->hasMigration(2));
        $this->assertTrue($map->hasMigration(3));
        $this->assertFalse($map->hasMigration(4));
        $m = $map->clearMigrations();
        $this->assertTrue($m instanceof Map);
        $this->assertEquals(0, count($map->getMigrations()));
        $this->assertFalse($map->hasMigration(1));
    }
    
    public function testConstruct()
    {
        $map = new Map(array(1 => 'a', 2 => 'b', 3 => 'c'));
        $this->assertEquals(3, count($map->getMigrations()));
    }
    
}
