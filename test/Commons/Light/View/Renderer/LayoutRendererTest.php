<?php

/**
 * =============================================================================
 * @file        Commons/Light/View/Renderer/LayoutRenderer.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\View\Renderer;

use Mock\Light\View as MockView;
use Commons\Light\View\ViewInterface;

class LayoutRendererTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetView()
    {
        $renderer = new LayoutRenderer();
        $this->assertTrue($renderer->getView() instanceof ViewInterface);
        $r = $renderer->setView(new MockView());
        $this->assertTrue($r instanceof RendererInterface);
        $this->assertTrue($renderer->getView() instanceof ViewInterface);
    }
    
    public function testSetGetLayoutPath()
    {
        $renderer = new LayoutRenderer();
        $this->assertNull($renderer->getLayoutPath());
        $r = $renderer->setLayoutPath('xxx');
        $this->assertTrue($r instanceof RendererInterface);
        $this->assertEquals('xxx', $renderer->getLayoutPath());
    }
    
    public function testSetIsEnabled()
    {
        $renderer = new LayoutRenderer();
        $this->assertTrue($renderer->isEnabled());
        $r = $renderer->setEnabled(false);
        $this->assertTrue($r instanceof RendererInterface);
        $this->assertFalse($renderer->isEnabled());
    }
    
    public function testRender()
    {
        $renderer = new LayoutRenderer();
        $renderer->setLayoutPath(ROOT_PATH.'/test/fixtures/test_layout_renderer.phtml');
        $content = $renderer->render('test');
        $this->assertContains('layout test', $content);
    }
    
    public function testRenderDisabled()
    {
        $renderer = new LayoutRenderer();
        $renderer->setEnabled(false);
        $this->assertEquals('test', $renderer->render('test'));
    }
    
}
