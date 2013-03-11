<?php

namespace Demo\Controller;

use Commons\Light\View\JsonView;
use Commons\Light\Controller\ActionController;

class RestController extends ActionController
{
    
    public function init()
    {
        parent::init();
        $this->getResponse()->setHeader('Content-Type', 'application/json');
    }

    public function getUserAction()
    {
        return new JsonView(array('method' => 'get'));
    }
    
    public function postUserAction()
    {
        return new JsonView(array(
            'method' => 'post',
            'body' => $this->getRequest()->getBody()
        ));
    }
    
    public function putUserAction()
    {
        return new JsonView(array(
            'method' => 'put',
            'body' => $this->getRequest()->getBody()
        ));
    }
    
    public function deleteUserAction()
    {
        return new JsonView(array(
            'method' => 'delete',
            'body' => $this->getRequest()->getBody()
        ));
    }
    
}
