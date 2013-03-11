<?php

/**
 * =============================================================================
 * @file        Commons/Xml/Writer.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Xml;

class Writer
{
    
    /**
     * Write xml to a string.
     * @param Commons\Xml\Xml $xml
     */
    public function writeToString(Xml $xml, $header = '')
    {
        return $header.$this->_recursiveGenerateXmlString($xml);
    }
    
    /**
     * Write xml to a file.
     * @param Commons\Xml\Xml $xml
     * @param string $filename
     * @param string $header
     * @throws Commons\Xml\Exception
     */
    public function writeToFile(Xml $xml, $filename, $header = null)
    {
        if (!isset($header)) {
            $header = '<?xml version="1.0" encoding="UTF-8"?>';
        }
        $str = $this->writeToString($xml, $header);
        if (@file_put_contents($filename, $str, LOCK_EX) === false) {
            throw new Exception("file_put_contents failed!");
        }
    }
    
    /**
     * Generate xml.
     * @param Commons\Xml\Xml $xml
     * @return string
     */
    protected function _recursiveGenerateXmlString(Xml $xml)
    {
        $data = $xml->getData();
        $str = '<'.$xml->getName();
        foreach ($xml->getAttributes() as $name => $value) {
            $str .= ' '.$name.'="'.htmlentities($value).'"';
        }
        if (empty($data)) {
            return $str.'/>';
        }
        $str .= '>';
        
        if (is_array($data)) {
            foreach ($xml as $node) {
                $str .= $this->_recursiveGenerateXmlString($node);
            }
        } else {
            $str .= htmlentities((string) $data);
        }
        
        return $str.'</'.$xml->getName().'>';
    }
    
}
