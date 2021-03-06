<?php

/**
 * =============================================================================
 * @file       Commons/Entity/EntityTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Entity;

class EntityTest extends \PHPUnit_Framework_TestCase
{
    
    public function testAccessors()
    {
        $entity = new Entity();
        $this->assertFalse(isset($entity->xxx));
        $this->assertNull($entity->xxx);
        $entity->xxx = 123;
        $this->assertTrue(isset($entity->xxx));
        $this->assertEquals(123, $entity->xxx);
    }
    
}
