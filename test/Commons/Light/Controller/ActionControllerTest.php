<?php

/**
 * =============================================================================
 * @file        Commons/Light/Controller/ActionControllerTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\Controller;

use Commons\Light\View\ScriptView;
use Commons\Light\View\ViewInterface;
use Commons\Light\View\Renderer\LayoutRenderer;
use Commons\Light\View\Renderer\RendererInterface;
use Mock\Light\ActionController as MockActionController;

class ActionControllerTest extends \PHPUnit_Framework_TestCase
{
    
    public function testSetGetViewRenderer()
    {
        $controller = new MockActionController();
        $this->assertTrue($controller->getViewRenderer() instanceof RendererInterface);
        $c = $controller->setViewRenderer(new LayoutRenderer());
        $this->assertTrue($c instanceof AbstractController);
        $this->assertTrue($controller->getViewRenderer() instanceof RendererInterface);
    }
    
    public function testSetGetView()
    {
        $controller = new MockActionController();
        $this->assertTrue($controller->getView() instanceof ViewInterface);
        $c = $controller->setView(new ScriptView());
        $this->assertTrue($c instanceof AbstractController);
        $this->assertTrue($controller->getView() instanceof ViewInterface);
    }

    public function testDispatchIndexAction()
    {
        $controller = new MockActionController();
        $result = $controller->dispatch(array('action' => 'index'));
        $this->assertEquals('index', $result);
        $contents = $controller->getResponse()->getBody();
        $this->assertContains('layout index action', $contents);
    }
    
    public function testDispatchCustomAction()
    {
        $controller = new MockActionController();
        $result = $controller->dispatch(array('action' => 'some-other'));
        $this->assertEquals('some other', $result);
        $contents = $controller->getResponse()->getBody();
        $this->assertContains('layout some other action', $contents);
    }
    
    public function testDispatchFailed()
    {
        $this->setExpectedException('\\Commons\\Light\\Controller\\Exception');
        $controller = new MockActionController();
        $controller->dispatch(array('action' => 'unknown'));
    }
    
}
