<?php

/**
 * =============================================================================
 * @file        Commons/Utils/DatetimeUtilsTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Utils;

class DatetimeUtilsTest extends \PHPUnit_Framework_TestCase
{

    public function testAgo_Now()
    {
        $time = $now = time();
        $this->assertEquals('0s', DatetimeUtils::ago($time, $now));
    }
    
    public function testAgo_Future()
    {
        $time = $now = time();
        $time++;
        $this->assertFalse(DatetimeUtils::ago($time, $now));
    }
    
    public function testAgo_Past()
    {
        $time = $now = time();
        $time -= 123456;
        $this->assertEquals('1d 10h 17m 36s', DatetimeUtils::ago($time, $now));
    }
    
}
