<?php

/**
 * =============================================================================
 * @file        Commons/Light/View/XmlView.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Light\View;

use Commons\Xml\Xml;
use Commons\Xml\Writer as XmlWriter;

class XmlView implements ViewInterface 
{
    
    protected $_xml;
    
    /**
     * Init xml view.
     * @param Xml $xml
     */
    public function __construct(Xml $xml = null)
    {
        $this->_xml = $xml;
    }
    
    /**
     * Set xml.
     * @param Xml $xml
     * @return \Commons\Light\View\XmlView
     */
    public function setXml(Xml $xml)
    {
        $this->_xml = $xml;
        return $this;
    }
    
    /**
     * Get xml.
     * @return Xml
     */
    public function getXml()
    {
        return $this->_xml;
    }
    
    /**
     * Render xml.
     * @return string
     */
    public function render($xml = null)
    {
        if (!isset($xml)) {
            $xml = $this->getXml();
        } 
        if (!($xml instanceof Xml)) {
            throw new Exception("Invalid Xml object");
        }
        $writer = new XmlWriter();
        return $writer->writeToString($xml, '<?xml version="1.0" encoding="UTF-8"?>');
    }
    
}
