<?php

/**
 * =============================================================================
 * @file       Mock/KeyStore.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Mock;

use Commons\KeyStore\KeyStoreInterface;

class KeyStore implements KeyStoreInterface 
{
    
    protected $_storage = array();
    
    public function connect($options = null)
    {
        return $this;
    }
    
    public function close()
    {
        return $this;
    }
    
    public function set($name, $value, $ttl = null)
    {
        $this->_storage[$name] = $value;
        return $this;
    }
    
    public function get($name, $defaultValue = null)
    {
        return (isset($this->_storage[$name]) ? $this->_storage[$name] : $defautlValue);
    }
    
    public function has($name)
    {
        return isset($this->_storage[$name]);
    }
    
    public function increment($name, $value = 1)
    {
        $this->_storage[$name] += $value;
        return $this;
    }
    
    public function decrement($name, $value = 1)
    {
        $this->_storage[$name] -= $value;
        return $this;
    }
    
    public function remove($name)
    {
        unset($this->_storage[$name]);
        return $this;
    }

}
