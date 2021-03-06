<?php

/**
 * =============================================================================
 * @file       Commons/Filter/Nl2BrFilterTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Filter;

class Nl2BrFilterTest extends \PHPUnit_Framework_TestCase
{
    
    public function testFilter()
    {
        $filter = new Nl2BrFilter();
        $this->assertEquals("abc<br />\ndef", $filter->filter("abc\ndef"));
    }
    
}
