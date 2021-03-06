<?php

/**
 * =============================================================================
 * @file       Commons/Light/Controller/ActionController.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Light\Controller;

use Commons\Callback\Callback;
use Commons\Callback\Exception as CallbackException;
use Commons\Light\Renderer\RendererInterface;
use Commons\Light\Renderer\LayoutRenderer;
use Commons\Light\View\PhtmlView;
use Commons\Light\View\Template\TemplateLocatorAwareInterface;
use Commons\Light\View\Template\TemplateAwareInterface;
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
            $this->setView(new PhtmlView());
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

        if ($this->getView() instanceof TemplateAwareInterface) {
            $controllerClass = basename(str_replace('\\', '/', get_class($this)));
            $controllerName = strtolower(str_replace('Controller', '', $controllerClass));
            $template = $controllerName.'/'.$actionName;
            $this->getView()->setTemplate($template);
        }
        
        if ($this->getView() instanceof TemplateLocatorAwareInterface) {
            $this->getView()->getTemplateLocator()->addLocation($this->getResourcesPath().'/views');
        }
        
        if ($this->getRenderer() instanceof LayoutRenderer) {
            $layout = $this->getRenderer()->getLayout();
            if ($layout instanceof TemplateAwareInterface) {
                $layout->setTemplate('layout');
            }
            if ($layout instanceof TemplateLocatorAwareInterface) {
                $layout->getTemplateLocator()->addLocation($this->getResourcesPath().'/views');
            }
        }
        
        try {
            $callback = new Callback($this, $actionMethod);
            $view = $callback->call();
            if (!($view instanceof ViewInterface)) {
                $view = $this->getView();
            }
            
        } catch (Exception $e) {
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
