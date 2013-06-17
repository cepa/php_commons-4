<?php

/**
 * =============================================================================
 * @file       Commons/Template/PhpTemplateTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Template;

class PhpTemplateTest extends \PHPUnit_Framework_TestCase
{
    
    public function testRender()
    {
        $template = new PhpTemplate();
        $template->xxx = 'test';
        $content = $template->render(ROOT_PATH.'/test/fixtures/test_script_view.phtml');
        $this->assertContains('hello test', $content);
    }
    
    public function testCascadeRender()
    {
        $template = new PhpTemplate();
        $template->xxx = 'world';
        $content = $template->render(ROOT_PATH.'/test/fixtures/test_cascade_render.phtml');
        $this->assertContains('this is hello world', $content);
    }
    
}
