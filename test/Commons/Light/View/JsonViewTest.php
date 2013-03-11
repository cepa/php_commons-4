<?php

/**
 * =============================================================================
 * @file        Commons/Light/View/JsonViewTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\View;

class JsonViewTest extends \PHPUnit_Framework_TestCase
{

    public function testView()
    {
        $view = new JsonView();
        $this->assertNull($view->getJson());
        $v = $view->setJson(array('test' => 123));
        $this->assertTrue($v instanceof ViewInterface);
        $this->assertTrue(is_array($view->getJson()));
        $this->assertEquals('{"test":123}', $view->render());
    }
    
}
