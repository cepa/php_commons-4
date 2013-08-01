<?php

/**
 * =============================================================================
 * @file       Commons/Xml/Writer.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Xml;

use Commons\Container\TraversableContainer;

class Writer
{
    
    /**
     * Write xml to a string.
     * @param Xml $xml
     */
    public function writeToString(Xml $xml, $header = '')
    {
        return $header.$this->_recursiveGenerateXmlString($xml);
    }
    
    /**
     * Write xml to a file.
     * @param Xml $xml
     * @param string $filename
     * @param string $header
     * @throws Exception
     */
    public function writeToFile(Xml $xml, $filename, $header = null)
    {
        if (!isset($header)) {
            $header = '<?xml version="1.0" encoding="UTF-8"?>' .PHP_EOL;
        }
        $str = $this->writeToString($xml, $header);
        if (@file_put_contents($filename, $str, LOCK_EX) === false) {
            throw new Exception("file_put_contents failed!");
        }
    }
    
    /**
     * Generate xml.
     * @param Xml $xml
     * @return string
     */
    protected function _recursiveGenerateXmlString(TraversableContainer $xml)
    {
        $data = $xml->getData();
        $itemName = '';
        $xmlName = ($xml->getName() != '' ? $xml->getName() : 'item');
        if (!ctype_alpha(substr($xmlName, 0, 1))) {
            $itemName = $xmlName;
            $xmlName = 'item';
        }        
        
        $str = '<'.$xmlName;
        if (!empty($itemName)) {
            $str .= ' name="'.htmlentities($itemName).'"';
        }
        if ($xml instanceof Xml) {
            foreach ($xml->getAttributes() as $name => $value) {
                $str .= ' '.$name.'="'.htmlentities($value).'"';
            }
        }
        if ($data == '') {
            return $str.'/>';
        }
        $str .= '>';
        
        if (is_array($data)) {
            foreach ($xml as $node) {
                $str .= $this->_recursiveGenerateXmlString($node);
            }
        } else {
            $text = (string) $data;
            if (preg_match('/^([A-Za-z0-9\-_\/\:\.\,\?\!\@\#\$\%\*\(\)\[\]\+\=\{\} ]+)$/', $text)) {
                $str .= $text;
            } else {
                $str .= '<![CDATA['.($text).']]>';
            }
        }
        
        return $str.'</'.$xmlName.'>';
    }
    
}
