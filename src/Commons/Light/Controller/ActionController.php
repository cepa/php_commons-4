<?php

/**
 * =============================================================================
 * @file        Commons/Light/Controller/ActionController.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\Controller;

use Commons\Callback\Callback;
use Commons\Callback\Exception as CallbackException;
use Commons\Light\View\Renderer\RendererInterface;
use Commons\Light\View\Renderer\LayoutRenderer;
use Commons\Light\View\ScriptView;
use Commons\Light\View\ViewInterface;

class ActionController extends AbstractController
{
    
    protected $_viewRenderer;
    
    /**
     * Set view renderer.
     * @param RendererInterface $renderer
     * @return \Commons\Light\Controller\ActionController
     */
    public function setViewRenderer(RendererInterface $renderer)
    {
        $this->_viewRenderer = $renderer;
        return $this;
    }
    
    /**
     * Get view renderer.
     * @return A\Commons\Light\Controller\LayoutRenderer
     */
    public function getViewRenderer()
    {
        if (!isset($this->_viewRenderer)) {
            $this->_viewRenderer = new LayoutRenderer();
        }
        return $this->_viewRenderer;
    }
    
    /**
     * Set view.
     * @param ViewInterface $view
     * @return \Commons\Light\Controller\ActionController
     */
    public function setView(ViewInterface $view)
    {
        $this->getViewRenderer()->setView($view);
        return $this;
    }
    
    /**
     * Get view.
     * @return \Commons\Light\View\ViewInterface
     */
    public function getView()
    {
        return $this->getViewRenderer()->getView();
    }
    
    /**
     * Dispatch action.
     * @see \Commons\Light\Controller\AbstractController::dispatch()
     * @return mixed
     */
    public function dispatch(array $params = array())
    {
        $this->preDispatch();
        
        $actionName = 'index';
        if (isset($params['action'])) {
            $actionName = $params['action'];    
        }
        
        $actionMethod = str_replace('-', ' ', $actionName);
        $actionMethod = str_replace(' ', '', ucwords($actionMethod));
        $actionMethod .= 'Action';
        $actionMethod = strtolower($actionMethod{0}).substr($actionMethod, 1);

        if ($this->getView() instanceof ScriptView) {
            $controllerClass = basename(str_replace('\\', '/', get_class($this)));
            $controllerName = strtolower(str_replace('Controller', '', $controllerClass));
            $scriptPath = $this->getResourcesPath().'/views/'.$controllerName.'/'.$actionName.'.phtml';
            $this->getView()->setScriptPath($scriptPath);
        }
        
        if ($this->getViewRenderer() instanceof LayoutRenderer) {
            $layoutPath = $this->getResourcesPath().'/views/layout.phtml';
            $this->getViewRenderer()->setLayoutPath($layoutPath);
        }
        
        try {
            $callback = new Callback($this, $actionMethod);
            $result = $callback->call();
            if ($result instanceof ViewInterface) {
                $this->getViewRenderer()->setView($result);
            }
            
        } catch (CallbackException $e) {
            $class = get_class($this);
            throw new Exception("Action '{$actionName}' was not found in controller '{$class}'");
        }
        
        $this->postDispatch();
        
        $contents = $this->getViewRenderer()->render();
        $this->getResponse()->appendBody($contents);
        
        return $result;
    }
    
    /**
     * Pre dispatch hook.
     */
    public function preDispatch()
    {
        
    }
    
    /**
     * Post dispatch hook.
     */
    public function postDispatch()
    {
        
    }
    
}
