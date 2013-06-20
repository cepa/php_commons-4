<?php

/**
 * =============================================================================
 * @file       Commons/Light/Renderer/LayoutRenderer.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\Renderer;

use Mock\Light\View as MockView;
use Commons\Light\View\ViewInterface;

class LayoutRendererTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetLayout()
    {
        $renderer = new LayoutRenderer();
        $this->assertTrue($renderer->getLayout() instanceof ViewInterface);
        $r = $renderer->setLayout(new MockView());
        $this->assertTrue($r instanceof RendererInterface);
        $this->assertTrue($renderer->getLayout() instanceof ViewInterface);
    }
    
    public function testEnableLayout()
    {
        $renderer = new LayoutRenderer();
        $this->assertTrue($renderer->isLayoutEnabled());
        $r = $renderer->enableLayout(false);
        $this->assertTrue($r instanceof RendererInterface);
        $this->assertFalse($renderer->isLayoutEnabled());
    }
    
    public function testEnableView()
    {
        $renderer = new LayoutRenderer();
        $this->assertTrue($renderer->isViewEnabled());
        $r = $renderer->enableView(false);
        $this->assertTrue($r instanceof RendererInterface);
        $this->assertFalse($renderer->isViewEnabled());
    }
    
    public function testRender()
    {
        $renderer = new LayoutRenderer();
        $renderer->getLayout()->getTemplateLocator()->addLocation(ROOT_PATH.'/test/fixtures');
        $renderer->getLayout()->setTemplate('test_layout_renderer');
        $content = $renderer->render(new MockView());
        $this->assertContains('layout test', $content);
    }
    
    public function testRenderWithDisabledView()
    {
        $renderer = new LayoutRenderer();
        $renderer->getLayout()->getTemplateLocator()->addLocation(ROOT_PATH.'/test/fixtures');
        $renderer
            ->enableView(false)
            ->getLayout()->setTemplate('test_layout_renderer');
        $content = $renderer->render(new MockView());
        $this->assertContains('layout ', $content);
    }
    
    public function testRenderWithDisabledLayout()
    {
        $renderer = new LayoutRenderer();
        $renderer->getLayout()->getTemplateLocator()->addLocation(ROOT_PATH.'/test/fixtures');
        $renderer
            ->enableLayout(false)
            ->getLayout()->setTemplate('test_layout_renderer');
        $content = $renderer->render(new MockView());
        $this->assertContains('test', $content);
    }
    
    public function testRenderWithDisabledLayoutAndView()
    {
        $renderer = new LayoutRenderer();
        $renderer->getLayout()->getTemplateLocator()->addLocation(ROOT_PATH.'/test/fixtures');
        $renderer
            ->enableLayout(false)
            ->enableView(false)
            ->getLayout()->setTemplate('test_layout_renderer');
        $content = $renderer->render(new MockView());
        $this->assertEquals('', $content);
    }
    
}
