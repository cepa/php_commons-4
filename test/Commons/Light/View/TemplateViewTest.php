<?php

/**
 * =============================================================================
 * @file        Commons/Light/View/TemplateViewTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\View;

class TemplateViewTest extends \PHPUnit_Framework_TestCase
{

    public function testView()
    {
        $view = new TemplateView();
        $this->assertNull($view->getTemplatePath());
        
        $view->xxx = 'test';
        $view->setTemplatePath(ROOT_PATH.'/test/fixtures/test_script_view.phtml');
        
        $contents = $view->render();
        $this->assertContains('hello test', $contents);
    }
    
    public function testRenderEmptyView()
    {
        $view = new TemplateView();
        $this->assertNull($view->render());
    }
    
    public function testViewTemplateNotFoundException()
    {
        $this->setExpectedException('Commons\\Template\\Exception');
        $view = new TemplateView();
        $view->setTemplatePath('some.file')->render();
    }
    
}
