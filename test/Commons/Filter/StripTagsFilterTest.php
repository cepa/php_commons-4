<?php

/**
 * =============================================================================
 * @file       Commons/Filter/StripTagsFilterTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Filter;

class StripTagsFilterTest extends \PHPUnit_Framework_TestCase
{
    
    public function testFilter()
    {
        $filter = new StripTagsFilter();
        $this->assertEquals("xxx", $filter->filter("<b aaa=\"yyy\">xxx<br />"));
    }
    
}
