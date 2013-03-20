<?php

/**
 * =============================================================================
 * @file        Commons/KeyMap/Key.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright   PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\KeyMap;

class Key
{
    
    protected $_unique;
    protected $_map;
    protected $_type;
    protected $_value;
    protected $_links = array();
    
    public function __construct()
    {
        
    }

    /**
     * Set unique identifier.
     * @param string $unique
     * @return \Commons\KeyMap\Key
     */
    public function setUnique($unique)
    {
        $this->_unique = $unique;
        return $this;
    }
    
    /**
     * Get unique identifier.
     * @return string
     */
    public function getUnique()
    {
        return $this->_unique;
    }
    
    /**
     * Set map instance.
     * @param Map $map
     * @return \Commons\KeyMap\Key
     */
    public function setMap(Map $map)
    {
        $this->_map = $map;
        return $this;
    }
    
    /**
     * Get map instance.
     * @throws Exception
     * @return Map
     */
    public function getMap()
    {
        if (!isset($this->_map)) {
            throw new Exception("There is no Map assigned to this object");
        }
        return $this->_map;
    }
    
    /**
     * Set type.
     * @param string|enum $type
     * @return \Commons\KeyMap\Key
     */
    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }
    
    /**
     * Get type.
     * @return string|enum
     */
    public function getType()
    {
        return $this->_type;
    }
    
    /**
     * Set value.
     * @param mixed $value
     * @return \Commons\KeyMap\Key
     */
    public function setValue($value)
    {
        $this->_value = $value;
        return $this;
    }
    
    /**
     * Get value.
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }
    
    /**
     * Add a link to a remote key by unique identifier.
     * @param string $unique
     * @return \Commons\KeyMap\Key
     */
    public function addLink($unique)
    {
        $this->_links[$unique] = $unique;
        return $this;
    }
    
    /**
     * Check if a remote key is linked to this one.
     * @param string $unique
     * @return boolean
     */
    public function hasLink($unique)
    {
        return (isset($this->_links[$unique]) ? true : false);
    }
    
    /**
     * Remove a link to a remote key.
     * @param string $unique
     * @return \Commons\KeyMap\Key
     */
    public function removeLink($unique)
    {
        unset($this->_links[$unique]);
        return $this;
    }
    
    /**
     * Set map of links to remote keys.
     * @param array $links
     * @return \Commons\KeyMap\Key
     */
    public function setLinks(array $links)
    {
        foreach ($links as $unique) {
            $this->addLink($unique);
        }
        return $this;
    }
    
    /**
     * Get map of remote links.
     * @return array<unique => unique>
     */
    public function getLinks()
    {
        return $this->_links;
    }
    
    /**
     * Save key in keystore.
     * @return \Commons\KeyMap\Key
     */
    public function save()
    {
        $this->getMap()->save($this);
        return $this;
    }
    
    /**
     * Delete key from keystore with all linked keys.
     * @return \Commons\KeyMap\Key
     */
    public function delete()
    {
        $this->getMap()->delete($this);
        return $this;
    }
    
    /**
     * Convert to string.
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }
    
}
