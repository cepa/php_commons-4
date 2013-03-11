<?php

/**
 * =============================================================================
 * @file        Commons/Light/Dispatcher/AbstractDispatcherTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\Dispatcher;

use Commons\Http\Response;
use Commons\Http\Request;
use Mock\Light\Dispatcher as MockDispatcher;

class AbstractDispatcherTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetRequest()
    {
        $controller = new MockDispatcher();
        $this->assertTrue($controller->getRequest() instanceof Request);
        $c = $controller->setRequest(new Request());
        $this->assertTrue($c instanceof AbstractDispatcher);
        $this->assertTrue($controller->getRequest() instanceof Request);
    }
    
    public function testSetGetResponse()
    {
        $controller = new MockDispatcher();
        $this->assertTrue($controller->getResponse() instanceof Response);
        $c = $controller->setResponse(new Response());
        $this->assertTrue($c instanceof AbstractDispatcher);
        $this->assertTrue($controller->getResponse() instanceof Response);
    }
    
}
