<?php

/**
 * =============================================================================
 * @file        Commons/KeyStore/RedisKeyStore.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright   PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\KeyStore;

use Predis\Client as PredisClient;

class RedisKeyStore implements KeyStoreInterface
{
    
    private $_predis;
    
    /**
     * Set predis client.
     * @param PredisClient $predis
     * @return \Commons\KeyStore\RedisKeyStore
     */
    public function setPredisClient(PredisClient $predis)
    {
        $this->_predis = $predis;
        return $this;
    }
    
    /**
     * Get predis client.
     * @return PredisClient
     */
    public function getPredisClient()
    {
        return $this->_predis;
    }
    
    /**
     * Connect to predis server
     * @param options
     * array(
     *     'servers' => array(
     *         array('scheme' => 'tcp', 'host' => '1.2.3.4', 'port' => 6379)
     *     ),
     *     'options' => array(...)
     * )
     * @see \Commons\KeyStore\KeyStoreInterface::connect()
     */
    public function connect($options = null)
    {
        $this->setPredisClient(new \Predis\Client($options['servers'], (isset($options['options']) ? $options['options'] : null)));
        return $this;
    }
    
    /**
     * Close connection.
     * @see \Commons\KeyStore\KeyStoreInterface::close()
     */
    public function close()
    {
        $this->getPredisClient()->disconnect();
        return $this;
    }
    
    /**
     * Set key value.
     * @see \Commons\KeyStore\KeyStoreInterface::set()
     */
    public function set($name, $value, $ttl = null)
    {
        $this->getPredisClient()->set($name, $value);
        if (isset($ttl)) $this->getPredisClient()->expire($name, $ttl);
        return $this;
    }
    
    /**
     * Get key value.
     * @see \Commons\KeyStore\KeyStoreInterface::get()
     */
    public function get($name, $defaultValue = null)
    {
        return ($this->has($name) ? $this->getPredisClient()->get($name) : $defaultValue);
    }
    
    /**
     * Has key?
     * @see \Commons\KeyStore\KeyStoreInterface::has()
     */
    public function has($name)
    {
        return $this->getPredisClient()->exists($name);
    }
    
    /**
     * Increment key value.
     * @see \Commons\KeyStore\KeyStoreInterface::increment()
     */
    public function increment($name, $value = 1)
    {
        $this->getPredisClient()->incrby($name, $value);
        return $this;
    }
    
    /**
     * Decrement key value.
     * @see \Commons\KeyStore\KeyStoreInterface::decrement()
     */
    public function decrement($name, $value = 1)
    {
        $this->getPredisClient()->decrby($name, $value);
        return $this;
    }
    
    /**
     * Remove key.
     * @see \Commons\KeyStore\KeyStoreInterface::remove()
     */
    public function remove($name)
    {
        $this->getPredisClient()->del($name);
        return $this;
    }
    
}
