<?php

/**
 * =============================================================================
 * @file       Commons/KeyStore/SessionKeyStore.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\KeyStore;

class SessionKeyStore extends AbstractKeyStore
{
    
    /**
     * Fake connect.
     * @see \Commons\KeyStore\KeyStoreInterface::connect()
     */
    public function connect($options = null)
    {
        // Dummy.
        return $this;
    }
    
    /**
     * Fake close.
     * @see \Commons\KeyStore\KeyStoreInterface::close()
     */
    public function close()
    {
        // Dummy.
        return $this;
    }
    
    /**
     * Set key value.
     * @see \Commons\KeyStore\KeyStoreInterface::set()
     */
    public function set($name, $value, $ttl = null)
    {
        $_SESSION[$name] = $value;
        return $this;
    }
    
    /**
     * Get key value.
     * @see \Commons\KeyStore\KeyStoreInterface::get()
     */
    public function get($name, $defaultValue = null)
    {
        return (isset($_SESSION[$name]) ? $_SESSION[$name] : $defaultValue);
    }
    
    /**
     * Has key?
     * @see \Commons\KeyStore\KeyStoreInterface::has()
     */
    public function has($name)
    {
        return isset($_SESSION[$name]);
    }
    
    /**
     * Increment by value.
     * @see \Commons\KeyStore\KeyStoreInterface::increment()
     */
    public function increment($name, $value = 1)
    {
        $_SESSION[$name] += $value;
        return $this;
    }
    
    /**
     * Decrement by value.
     * @see \Commons\KeyStore\KeyStoreInterface::decrement()
     */
    public function decrement($name, $value = 1)
    {
        $_SESSION[$name] -= $value;
        return $this;
    }
    
    /**
     * Remove key.
     * @see \Commons\KeyStore\KeyStoreInterface::remove()
     */
    public function remove($name)
    {
        unset($_SESSION[$name]);
        return $this;
    }
    
}
