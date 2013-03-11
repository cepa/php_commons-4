<?php

/**
 * =============================================================================
 * @file        Commons/Filter/Nl2BrFilterTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
