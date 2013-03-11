<?php

/**
 * =============================================================================
 * @file        Commons/KeyStore/ApcKeyStore.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright   PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\KeyStore;

use Commons\Exception\MissingDependencyException;

class ApcKeyStore implements KeyStoreInterface
{
    
    private $_hasApcExists = true;
    
    /**
     * Init APC keystore.
     * @throws MissingDependencyException
     */
    public function __construct()
    {
        if (!extension_loaded('apc')) {
            throw new MissingDependencyException("Missing APC extension");
        }
        if (!function_exists('apc_exists')) {
            $this->_hasApcExists = false;
        }
    }
    
    /**
     * Not used.
     * @see \Commons\KeyStore\KeyStoreInterface::connect()
     */
    public function connect($options = null)
    {
        return $this;
    }
    
    /**
     * Not used.
     * @see \Commons\KeyStore\KeyStoreInterface::close()
     */
    public function close()
    {
        return $this;
    }
    
    /**
     * Set key value.
     * @see \Commons\KeyStore\KeyStoreInterface::set()
     */
    public function set($name, $value, $ttl = null)
    {
        apc_store($name, $value, $ttl);
        return $this;
    }
    
    /**
     * Get key value.
     * @see \Commons\KeyStore\KeyStoreInterface::get()
     */
    public function get($name, $defaultValue = null)
    {
        return ($this->has($name) ? apc_fetch($name) : $defaultValue); 
    }
    
    /**
     * Has key value.
     * @see \Commons\KeyStore\KeyStoreInterface::has()
     */
    public function has($name)
    {
        if ($this->_hasApcExists) {
            $result = apc_exists($name);
        } else {
            $result;
            apc_fetch($name, $result);
        }
        
        return ($result ? true : false);
    }
    
    /**
     * Increment key by value.
     * @see \Commons\KeyStore\KeyStoreInterface::increment()
     */
    public function increment($name, $value = 1)
    {
        if ($this->has($name)) {
            apc_inc($name, $value);
        }
        return $this;
    }
    
    /**
     * Decrement key by value.
     * @see \Commons\KeyStore\KeyStoreInterface::decrement()
     */
    public function decrement($name, $value = 1)
    {
        if ($this->has($name)) {
            apc_dec($name, $value);
        }
        return $this;
    }
    
    /**
     * Remove key.
     * @see \Commons\KeyStore\KeyStoreInterface::remove()
     */
    public function remove($name)
    {
        apc_delete($name);
        return $this;
    }
    
}
