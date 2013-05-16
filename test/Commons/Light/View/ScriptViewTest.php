<?php

/**
 * =============================================================================
 * @file        Commons/Light/View/ScriptViewTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\View;

class ScriptViewTest extends \PHPUnit_Framework_TestCase
{

    public function testView()
    {
        $view = new ScriptView();
        $this->assertNull($view->getScriptPath());
        
        $view->xxx = 'test';
        $view->setScriptPath(ROOT_PATH.'/test/fixtures/test_script_view.phtml');
        
        $contents = $view->render();
        $this->assertContains('hello test', $contents);
    }
    
    public function testRenderEmptyView()
    {
        $view = new ScriptView();
        $this->assertNull($view->render());
    }
    
    public function testViewScriptNotFoundException()
    {
        $this->setExpectedException('Commons\\Light\\View\\Exception');
        $view = new ScriptView();
        $view->setScriptPath('some.file')->render();
    }
    
}
