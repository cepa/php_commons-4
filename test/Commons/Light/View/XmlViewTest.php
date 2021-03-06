<?php

/**
 * =============================================================================
 * @file       Commons/Light/View/XmlViewTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\View;

use Commons\Xml\Xml;

class XmlViewTest extends \PHPUnit_Framework_TestCase
{

    public function testView()
    {
        $xml = new Xml();
        $xml->a = 123;
        $xml->b = 456;
        
        $view = new XmlView();
        $this->assertNull($view->getXml());
        $v = $view->setXml($xml);
        $this->assertTrue($v instanceof ViewInterface);
        
        $contents = $view->render();
        $this->assertEquals('<?xml version="1.0" encoding="UTF-8"?><xml><a>123</a><b>456</b></xml>', $contents);
    }
    
}
