<?php

/**
 * =============================================================================
 * @file        Commons/Filter/ToLowerFilterTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Filter;

class ToLowerFilterTest extends \PHPUnit_Framework_TestCase
{
    
    public function testFilter()
    {
        $filter = new ToLowerFilter();
        $this->assertEquals("abc", $filter->filter("AbC"));
    }
    
}
