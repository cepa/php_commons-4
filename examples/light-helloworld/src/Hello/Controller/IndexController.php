<?php

namespace Hello\Controller;

use Commons\Light\Controller\ActionController;

class IndexController extends ActionController
{
    
    public function indexAction()
    {
        $this->getView()->message = 'Hello World!';
    }
    
}