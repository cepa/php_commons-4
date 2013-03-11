<?php

/**
 * =============================================================================
 * @file        Commons/Light/Application/WebApplicationTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\Application;

class WebApplicationTest extends \PHPUnit_Framework_TestCase
{
    
    public function testApp()
    {
        $app = new WebApplication();
        $this->assertTrue($app instanceof AbstractApplication);
    }

}
