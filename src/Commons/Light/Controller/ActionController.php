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
use Commons\Light\Renderer\RendererInterface;
use Commons\Light\Renderer\LayoutRenderer;
use Commons\Light\View\TemplateView;
use Commons\Light\View\ViewInterface;

class ActionController extends AbstractController
{
    
    protected $_view;
    protected $_renderer;
    
    /**
     * Set view.
     * @param ViewInterface $view
     * @return \Commons\Light\Controller\ActionController
     */
    public function setView(ViewInterface $view)
    {
        $this->_view = $view;
        return $this;
    }
    
    /**
     * Get view.
     * @return \Commons\Light\View\ViewInterface|ScriptView
     */
    public function getView()
    {
        if (!isset($this->_view)) {
            $this->setView(new TemplateView());
        }
        return $this->_view;
    }
    
    /**
     * Set renderer.
     * @param RendererInterface $renderer
     * @return \Commons\Light\Controller\ActionController
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->_renderer = $renderer;
        return $this;
    }
    
    /**
     * Get  renderer.
     * @return LayoutRenderer
     */
    public function getRenderer()
    {
        if (!isset($this->_renderer)) {
            $this->_renderer = new LayoutRenderer();
        }
        return $this->_renderer;
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

        if ($this->getView() instanceof TemplateView) {
            $controllerClass = basename(str_replace('\\', '/', get_class($this)));
            $controllerName = strtolower(str_replace('Controller', '', $controllerClass));
            $scriptPath = $this->getResourcesPath().'/views/'.$controllerName.'/'.$actionName.'.phtml';
            $this->getView()->setTemplatePath($scriptPath);
        }
        
        if ($this->getRenderer() instanceof LayoutRenderer) {
            $layoutPath = $this->getResourcesPath().'/views/layout.phtml';
            $this->getRenderer()->getLayout()->setTemplatePath($layoutPath);
        }
        
        try {
            $callback = new Callback($this, $actionMethod);
            $view = $callback->call();
            if (!($view instanceof ViewInterface)) {
                $view = $this->getView();
            }
            
        } catch (CallbackException $e) {
            $class = get_class($this);
            throw new Exception("Action '{$actionName}' was not found in controller '{$class}'");
        }
        
        $this->postDispatch();
        
        $contents = $this->getRenderer()->render($view);
        $this->getResponse()->appendBody($contents);
        
        return $this;
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
