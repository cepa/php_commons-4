<?php

/**
 * =============================================================================
 * @file       Commons/Light/View/PhtmlViewTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\View;

class PhtmlViewTest extends \PHPUnit_Framework_TestCase
{

    public function testView()
    {
        $view = new PhtmlView();
        $this->assertNull($view->getTemplate());
        
        $view->xxx = 'test';
        $view->setTemplate('test_script_view');
        $view->getTemplateLocator()->addLocation(ROOT_PATH.'/test/fixtures');
        
        $contents = $view->render();
        $this->assertContains('hello test', $contents);
    }
    
    public function testRenderEmptyView()
    {
        $view = new PhtmlView();
        $this->assertNull($view->render());
    }
    
    public function testViewTemplateNotFoundException()
    {
        $this->setExpectedException('Commons\Light\View\Phtml\Exception');
        $view = new PhtmlView();
        $view->setTemplate('some.file')->render();
    }
    
}
