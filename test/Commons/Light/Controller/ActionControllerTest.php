<?php

/**
 * =============================================================================
 * @file       Commons/Light/Controller/ActionControllerTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\Controller;

use Commons\Light\View\PhtmlView;
use Commons\Light\View\ViewInterface;
use Commons\Light\Renderer\LayoutRenderer;
use Commons\Light\Renderer\RendererInterface;
use Mock\Light\ActionController as MockActionController;

class ActionControllerTest extends \PHPUnit_Framework_TestCase
{
    
    public function testSetGetRenderer()
    {
        $controller = new MockActionController();
        $this->assertTrue($controller->getRenderer() instanceof RendererInterface);
        $c = $controller->setRenderer(new LayoutRenderer());
        $this->assertTrue($c instanceof AbstractController);
        $this->assertTrue($controller->getRenderer() instanceof RendererInterface);
    }
    
    public function testSetGetView()
    {
        $controller = new MockActionController();
        $this->assertTrue($controller->getView() instanceof ViewInterface);
        $c = $controller->setView(new PhtmlView());
        $this->assertTrue($c instanceof AbstractController);
        $this->assertTrue($controller->getView() instanceof ViewInterface);
    }

    public function testDispatchIndexAction()
    {
        $controller = new MockActionController();
        $result = $controller->dispatch(array('action' => 'index'));
        $this->assertTrue($result instanceof ActionController);
        $contents = $controller->getResponse()->getBody();
        $this->assertContains('layout index action', $contents);
    }
    
    public function testDispatchCustomAction()
    {
        $controller = new MockActionController();
        $result = $controller->dispatch(array('action' => 'some-other'));
        $this->assertTrue($result instanceof ActionController);
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
