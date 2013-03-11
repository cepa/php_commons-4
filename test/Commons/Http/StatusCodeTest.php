<?php

/**
 * =============================================================================
 * @file        Commons/Http/StatusCodeTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Http;

class StatusCodeTest extends \PHPUnit_Framework_TestCase
{
    
    public function testGetMessage()
    {
        $this->assertEquals('OK', StatusCode::getMessage(StatusCode::HTTP_OK));
    }
        
}
