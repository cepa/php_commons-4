<?php

/**
 * =============================================================================
 * @file        Commons/Xml/Reader.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Xml;

use Commons\Exception\FileNotFoundException;
use Commons\Exception\NotFoundException;

class Reader
{
    
	protected $_properties = array();
	
	/**
	 * Set properties.
	 * @param array $properties
	 * @return Reader
	 */
	public function setProperties(array $properties) 
	{
		$this->_properties = $properties;
		return $this;
	}
	
	/**
	 * Get properties.
	 * @return array
	 */
	public function getProperties()
	{
		return $this->_properties;
	}
	
	/**
	 * Clear properties.
	 * @return Reader
	 */
	public function clearProperties()
	{
		$this->_properties = array();
		return $this;
	}
	
	/**
	 * Set property.
	 * @param string $name
	 * @param string $value
	 * @return Reader
	 */
	public function setProperty($name, $value)
	{
		$this->_properties[(string) $name] = (string) $value;
		return $this;
	}
	
	/**
	 * Get property.
	 * @param string $name
	 * @throws NotFoundException
	 * @return string
	 */
	public function getProperty($name)
	{
		if (!isset($this->_properties[(string) $name])) {
			throw new Exception("Property '{$name}' does not exist!");
		}
		return $this->_properties[(string) $name];
	}
	
	/**
	 * Has property.
	 * @param string $name
	 * @return boolean
	 */
	public function hasProperty($name)
	{
		return isset($this->_properties[(string) $name]);
	}
	
	/**
	 * Remove property.
	 * @param string $name
	 * @return Reader
	 */
	public function removeProperty($name)
	{
		unset($this->_properties[(string) $name]);
		return $this;
	}
	
	/**
     * Parse XML from string.
     * @param string $str
     * @throws Exception
     * @return Reader
     */
    public function readFromString($str)
    {
    	$str = $this->_parseProperties($str);
        libxml_use_internal_errors(true);
        $simple = @simplexml_load_string($str);
        if (!$simple) {
            $message = 'simplexml_load_string failed';
            foreach (libxml_get_errors() as $error) {
                $message .= ': '.$error->message;
            }
            libxml_clear_errors();
            throw new Exception($message);
        }
        return $this->_convertSimpleXmlToCommonsXml($simple);
    }
    
    /**
     * Read xml from file.
     * @param string $filename
     * @throws Exception
     * @return Reader
     */
    public function readFromFile($filename)
    {
        if (!file_exists($filename)) {
            throw new Exception("Cannot read file {$filename}!");
        }
        return $this->readFromUrl($filename);
    }
    
    /**
     * Read xml from url.
     * @param string $url
     * @return Reader
     */
    public function readFromUrl($url)
    {
        $str = @file_get_contents($url);
        if ($str === false) {
            throw new Exception("file_get_contents failed!");
        }
        return $this->readFromString($str);
    }
    
    /**
     * Recursive convert simple xml to commons xml.
     * @param \SimpleXMLElement $simple
     * @return Reader
     */
    protected function _convertSimpleXmlToCommonsXml(\SimpleXMLElement $simple)
    {
        $xml = new Xml($simple->getName());
        $xml->setText((string) $simple);
        foreach ($simple->attributes() as $name => $value) {
            $xml->setAttribute((string) $name, (string) $value);
        }
        foreach ($simple->children() as $child) {
            $xml->addChild($this->_convertSimpleXmlToCommonsXml($child));
        }
        return $xml;
    }
    
    /**
     * Parse properties.
     * @param string $str
     * @return string
     */
    protected function _parseProperties($str)
    {
    	foreach ($this->_properties as $name => $value) {
    		$str = str_replace('${'.$name.'}', (string) $value, $str);
    	}
    	return $str;
    }
    
}
