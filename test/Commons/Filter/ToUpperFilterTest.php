<?php

/**
 * =============================================================================
 * @file       Commons/Filter/ToUpperFilterTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Filter;

class ToUpperFilterTest extends \PHPUnit_Framework_TestCase
{
    
    public function testFilter()
    {
        $filter = new ToUpperFilter();
        $this->assertEquals("ABC", $filter->filter("aBc"));
    }
    
}
