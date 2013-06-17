<?php

/**
 * =============================================================================
 * @file       Commons/Light/View/XmlView.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
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
    public function render($content = null)
    {
        $writer = new XmlWriter();
        return $writer->writeToString($this->getXml(), '<?xml version="1.0" encoding="UTF-8"?>');
    }
    
}
