<?php

namespace Demo\Controller;

use Commons\Light\Controller\ActionController;

class CustomController extends ActionController
{
    
    public function indexAction()
    {
        
    }

    public function simpleRouteAction()
    {
        
    }
    
    public function regexRouteAction()
    {
        $this->getView()->x = $this->getRequest()->getParam('x');
        $this->getView()->y = $this->getRequest()->getParam('y');
    }
    
}
