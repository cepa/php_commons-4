<?php

/**
 * =============================================================================
 * @file       Commons/KeyStore/KeyStoreInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\KeyStore;

interface KeyStoreInterface 
{
    
    /**
     * Open a connection to a key store.
     * @param mixed $options
     * @return KeyStoreInterface
     */
    public function connect($options = null);
    
    /**
     * Close connection to a key store.
     * @return KeyStoreInterface
     */
    public function disconnect();
    
    /**
     * Set key value.
     * @param string $name
     * @param mixed $value
     * @param int $ttl
     * @return KeyStoreInterface
     */
    public function set($name, $value, $ttl = null);
    
    /**
     * Get key value.
     * @param string $name
     * @param mixed $defaultValue
     * @return mixed
     */
    public function get($name, $defaultValue = null);
    
    /**
     * Has key?
     * @param string $name
     * @return boolean
     */
    public function has($name);
    
    /**
     * Increment key by value.
     * @note DOES NOT CREATE AN ITEM IF IT DID NOT EXIST.
     * @param string $name
     * @param number $value
     * @return KeyStoreInterface
     */
    public function increment($name, $value = 1);
    
    /**
     * Decrement key by value.
     * @note DOES NOT CREATE AN ITEM IF IT DID NOT EXIST.
     * @param mixed $name
     * @param number $value
     * @return KeyStoreInterface
     */
    public function decrement($name, $value = 1);
    
    /**
     * Remove key.
     * @param string $name
     * @return KeyStoreInterface
     */
    public function remove($name);
    
}
