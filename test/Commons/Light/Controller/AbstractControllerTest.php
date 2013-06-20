<?php

/**
 * =============================================================================
 * @file       Commons/Light/Controller/AbstractControllerTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\Controller;

use Commons\Http\Response;
use Commons\Http\Request;
use Mock\Light\Controller as MockController;

class AbstractControllerTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetRequest()
    {
        $controller = new MockController();
        $this->assertTrue($controller->getRequest() instanceof Request);
        $c = $controller->setRequest(new Request());
        $this->assertTrue($c instanceof AbstractController);
        $this->assertTrue($controller->getRequest() instanceof Request);
    }
    
    public function testSetGetResponse()
    {
        $controller = new MockController();
        $this->assertTrue($controller->getResponse() instanceof Response);
        $c = $controller->setResponse(new Response());
        $this->assertTrue($c instanceof AbstractController);
        $this->assertTrue($controller->getResponse() instanceof Response);
    }
    
    public function testSetGetResourcesPath()
    {
        $controller = new MockController();
        $this->assertEquals(ROOT_PATH.'/test/Mock/Resources', $controller->getResourcesPath());
        $c = $controller->setResourcesPath('xxx');
        $this->assertTrue($c instanceof AbstractController);
        $this->assertEquals('xxx', $controller->getResourcesPath());
    }
    
}
