<?php

/**
 * =============================================================================
 * @file        Commons/Config/Adapter/XmlAdapter.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Config\Adapter;

use Commons\Exception\InvalidArgumentException;
use Commons\Xml\Xml;
use Commons\Xml\Reader as XmlReader;

class XmlAdapter extends AbstractAdapter
{
    
    protected $_reader;
    
    public function setReader(XmlReader $reader)
    {
        $this->_reader = $reader;
        return $this;
    }
    
    public function getReader()
    {
        if (!isset($this->_reader)) {
            $this->_reader = new XmlReader();
        }
        return $this->_reader;
    }

    /**
     * Load.
     * @see Commons\Config\Adapter\AdapterInterface::load()
     */
    public function load($loadable)
    {
        if (is_string($loadable)) {
            $xml = $this->getReader()->readFromString($loadable);
        } else if ($loadable instanceof Xml) {
            $xml = $loadable;
        } else {
            throw new InvalidArgumentException();
        }
        $this->_loadXml($xml);
    }
    
    /**
     * Load from file.
     * @see Commons\Config\Adapter\AdapterInterface::loadFromFile()
     */
    public function loadFromFile($filename)
    {
        $this->_loadXml($this->getReader()->readFromFile($filename));
    }
    
    protected function _loadXml(Xml $root)
    {
        $environment = $this->getConfig()->getEnvironment();
        if (!empty($environment)) {
            $this->getConfig()->copy($this->_loadExtendedNode($root, $root->getChild($environment)));
        } else {
            $this->getConfig()->copy($root);
        }
    }
    
    protected function _loadExtendedNode(Xml $root, Xml $node)
    {
        if ($node->hasAttribute('extends')) {
            $inheritNode = $this->_loadExtendedNode($root, $root->getChild($node->getAttribute('extends')));
            $mergedNode = new Xml();
            $mergedNode
                ->copy($inheritNode)
                ->alter($node);
            return $mergedNode;
        }
        return $node;
    }
    
}
