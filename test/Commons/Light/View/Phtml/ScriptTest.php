<?php

/**
 * =============================================================================
 * @file       Commons/Light/View/Phtml/ScriptTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\View\Phtml;

class ScriptTest extends \PHPUnit_Framework_TestCase
{
    
    public function testRender()
    {
        $template = new Script();
        $template->xxx = 'test';
        $template->getTemplateLocator()->addLocation(ROOT_PATH.'/test/fixtures');
        $content = $template->render('test_script_view');
        $this->assertContains('hello test', $content);
    }
    
    public function testCascadeRender()
    {
        $template = new Script();
        $template->xxx = 'world';
        $template->getTemplateLocator()->addLocation(ROOT_PATH.'/test/fixtures');
        $content = $template->render('test_cascade_render');
        $this->assertContains('this is hello world', $content);
    }
    
}
