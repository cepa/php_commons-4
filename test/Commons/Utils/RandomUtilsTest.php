<?php

/**
 * =============================================================================
 * @file       Commons/Utils/RandomUtilsTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Utils;

class RandomUtilsTest extends \PHPUnit_Framework_TestCase
{
    
    public function testRandomString()
    {
        $this->assertEquals(3, strlen(RandomUtils::randomString(3)));
        $this->assertEquals(6, strlen(RandomUtils::randomString(6)));
        $this->assertEquals(12, strlen(RandomUtils::randomString(12)));
    }
    
    public function testRandomUuid()
    {
        $this->assertEquals(36, strlen(RandomUtils::randomUuid()));
    }
    
}
