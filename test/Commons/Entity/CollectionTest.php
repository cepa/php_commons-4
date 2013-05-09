<?php

/**
 * =============================================================================
 * @file        Commons/Entity/CollectionTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Entity;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    
    public function testCollectionAccess()
    {
        $c = new Collection();
        $c[] = new Entity();
        $c[] = new Entity();
        $c[] = new Entity();
        
        $this->assertEquals(3, count($c));

        $c[1]->xxx = 123;
        $this->assertTrue(isset($c[1]->xxx));
        $this->assertEquals(123, $c[1]->xxx);
        
        unset($c[1]);
        $this->assertEquals(2, count($c));
        $this->assertFalse(isset($c[1]));
    }
    
}
