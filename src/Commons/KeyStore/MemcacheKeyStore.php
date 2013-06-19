<?php

/**
 * =============================================================================
 * @file       Commons/KeyStore/MemcacheKeyStore.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\KeyStore;

class MemcacheKeyStore extends AbstractKeyStore
{
    
    private $_memcache;
    
    /**
     * Init Memcache keystore.
     * @throws MissingDependencyException
     */
    public function __construct()
    {
        if (!class_exists('Memcache')) {
            throw new Exception("Missing Memcache extension");
        }
    }
    
    /**
     * Set memcache connection.
     * @param \Memcache $memcache
     * @return \Commons\KeyStore\MemcacheKeyStore
     */
    public function setMemcacheConnection(\Memcache $memcache)
    {
        $this->_memcache = $memcache;
        return $this;
    }
    
    /**
     * Get memcache connection.
     * @return Memcache
     */
    public function getMemcacheConnection()
    {
        if (!isset($this->_memcache)) {
            $this->setMemcacheConnection(new \Memcache());
        }
        return $this->_memcache;
    }
    
    /**
     * Connect to memcache.
     * @param $options array(
     *     'pool' => array(
     *         array('host' => 'memcache-server1', 'port' => 11211),
     *         array('host' => 'memcache-server2', 'port' => 11211)
     *     ),
     *     'host' => 'memcache-server',
     *     'port' => 11211,
     *     'persistent' => true|false
     * )
     * @see \Commons\KeyStore\KeyStoreInterface::connect()
     */
    public function connect($options = null)
    {
        if (is_array($options)) {
            
            if (isset($options['pool'])) {
                foreach ($options['pool'] as $server) {
                    $this->getMemcacheConnection()
                        ->addServer($server['host'], isset($server['port']) ? $server['port'] : 11211);
                }
            
            } else if (isset($options['host'])) {
                $host = $options['host'];
                $port = (isset($options['port']) ? $options['port'] : 11211);
                if (isset($options['persistent']) && $options['persistent'] == true) {
                    $this->getMemcacheConnection()->pconnect($host, $port);
                } else {
                    $this->getMemcacheConnection()->connect($host, $port);
                }
            }
            
        }
        return $this;
    }
    
    /**
     * Close connection.
     * @see \Commons\KeyStore\KeyStoreInterface::disconnect()
     */
    public function disconnect()
    {
        $this->getMemcacheConnection()->close();
        return $this;
    }
    
    /**
     * Set key value.
     * @see \Commons\KeyStore\KeyStoreInterface::set()
     */
    public function set($name, $value, $ttl = null)
    {
        $this->getMemcacheConnection()->set($name, $value, 0, $ttl);
        return $this;
    }
    
    /**
     * Get key value.
     * @see \Commons\KeyStore\KeyStoreInterface::get()
     */
    public function get($name, $defaultValue = null)
    {
        return ($this->has($name) ? $this->getMemcacheConnection()->get($name) : $defaultValue);
    }
    
    /**
     * Has key?
     * @see \Commons\KeyStore\KeyStoreInterface::has()
     */
    public function has($name)
    {
        $result = $this->getMemcacheConnection()->get($name);
        if (!$result || (is_array($result) && count($result) == 0)) {
            return false;
        }
        return true;
    }
    
    /**
     * Increment key by value.
     * @see \Commons\KeyStore\KeyStoreInterface::increment()
     */
    public function increment($name, $value = 1)
    {
        if ($this->has($name)) {
            $this->getMemcacheConnection()->increment($name, $value);
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
            $this->getMemcacheConnection()->decrement($name, $value);
        }
        return $this;
    }
    
    /**
     * Remove key.
     * @see \Commons\KeyStore\KeyStoreInterface::remove()
     */
    public function remove($name)
    {
        $this->getMemcacheConnection()->delete($name);
        return $this;
    }
    
}
