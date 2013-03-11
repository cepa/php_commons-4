<?php

/**
 * =============================================================================
 * @file        Commons/Xml/Xml.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Xml;

use Commons\Container\AssocContainer;
use Commons\Container\TraversableContainer;

class Xml extends TraversableContainer implements \Serializable
{
    
    protected $_attributes;
    
    public function __construct($name = 'xml')
    {
        parent::__construct($name);
    }
    
    /**
     * Clear.
     * @see Commons\Container\TraversableContainer::clear()
     * @return Commons\Xml\Xml
     */
    public function clear()
    {
        parent::clear();
        $this->_attributes = new AssocContainer();
        return $this;
    }
    
    public function merge(Xml $source)
    {
        parent::merge($source);
        foreach ($source->_attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }
        return $this;
    }
    
    public function alter(Xml $source)
    {
        parent::alter($source);
        foreach ($source->_attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }
        return $this;
    }
    
    /**
     * Set text, reset to text data.
     * @param string $text
     * @return Commons\Xml\Xml
     */
    public function setText($text)
    {
        return $this->setData((string) $text);
    }
    
    /**
     * Get data as text.
     * @return string
     */
    public function getText()
    {
        return (string) $this->getData();
    }
    
    /**
     * Set attributes.
     * @param Commons\Container\AssocContainer $attributes
     * @return Commons\Xml\Xml
     */
    public function setAttributes(AssocContainer $attributes)
    {
        $this->_attributes = $attributes;
        return $this;
    }
    
    /**
     * Get attributes.
     * @return Commons\Container\AssocContainer
     */
    public function getAttributes()
    {
        return $this->_attributes;
    }
    
    /**
     * Set attribute.
     * @param string $name
     * @param mixed $value
     * @return Commons\Container\TraversableContainer
     */
    public function setAttribute($name, $value)
    {
        $this->_attributes->set($name, $value);
        return $this;
    }
    
    /**
     * Get attribute.
     * @param string $name
     * @return mixed
     */
    public function getAttribute($name)
    {
        return $this->_attributes->get($name);
    }
    
    /**
     * Has attribute.
     * @param string $name
     * @return boolean
     */
    public function hasAttribute($name)
    {
        return $this->_attributes->has($name);
    }
    
    /**
     * Remove attribute.
     * @param string $name
     * @return Commons\Container\TraversableContainer
     */
    public function removeAttribute($name)
    {
        $this->_attributes->remove($name);
        return $this;
    }
    
    /**
     * Xpath implementation.
     * @param string $path
     * @return Commons\Xml\Xml
     */
    public function xpath($path)
    {
        $tokens = explode('/', trim($path, '/'));
        $node = $this;
        foreach ($tokens as $token) {
            $node = $node->getChild(trim($token));
        }
        return $node;
    }
    
    /**
     * Convert xml to string.
     * @return string
     */
    public function toString()
    {
        if (is_array($this->_data)) {
        	$writer = new Writer();
            return $writer->writeToString($this);
        }
        return (string) $this->_data;
    }
    
    /**
     * Write xml to a file.
     * @param string $filename
     * @return Commons\Xml\Xml
     */
    public function toFile($filename, $header = null)
    {
    	$writer = new Writer();
        $writer->writeToFile($this, $filename, $header);
        return $this;
    }
    
    /**
     * Alias for toString().
     * @see Commons\Container\TraversableContainer::__toString()
     */
    public function __toString()
    {
        return $this->toString();
    }
    
    /**
     * Serializable
     * @return string
     */
    public function serialize()
    {
        return $this->__toString();
    }
    
    /**
     * Serializable
     * @param unknown_type $serialized
     * @return Commons\Xml\Xml
     */
    public function unserialize($serialized)
    {
    	$reader = new Reader();
        $this->copy($reader->readFromString($serialized));
        return $this;
    }
    
    /**
     * Parse xml from a string.
     * @param string $str
     * @return Commons\Xml\Xml
     */
    public static function createFromString($str)
    {
    	$reader = new Reader();
        return $reader->readFromString($str);
    }
    
    /**
     * Parse xml from a file.
     * @param string $filename
     * @return Commons\Xml\Xml
     */
    public static function createFromFile($filename)
    {
    	$reader = new Reader();
        return $reader->readFromFile($filename);
    }
    
    /**
     * Parse xml from an url.
     * @param string $url
     * @return Commons\Xml\Xml
     */
    public static function createFromUrl($url)
    {
    	$reader = new Reader();
        return $reader->readFromUrl($url);
    }
    
    protected function _createNewChild($name = null)
    {
        return new Xml($name);
    }
    
}
