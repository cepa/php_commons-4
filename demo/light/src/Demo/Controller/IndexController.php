<?php

namespace Demo\Controller;

use Commons\Light\Controller\ActionController;
use Commons\Light\View\JsonView;
use Commons\Light\View\XmlView;
use Commons\Xml\Xml;

class IndexController extends ActionController
{

    public function indexAction()
    {
        $this->getView()->xxx = '666';
    }
    
    public function secondAction()
    {
        $this->getView()->x = $this->getRequest()->getParam('x');
    }
    
    public function jsonAction()
    {
        $this->getResponse()->setHeader('Content-Type', 'application/json');
        return new JsonView(array('name' => 'value'));
    }
    
    public function xmlAction()
    {
        $xml = new Xml();
        $xml->x = 123;
        $xml->y = 456;
        $xml->z->a = 'abc';
        $xml->z->b = 'xyz';
        
        $this->getResponse()->setHeader('Content-Type', 'application/xml');
        return new XmlView($xml);
    }
    
}
