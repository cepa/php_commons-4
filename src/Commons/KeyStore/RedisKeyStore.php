<?php

/**
 * =============================================================================
 * @file       Commons/KeyStore/RedisKeyStore.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\KeyStore;

use Predis\Client as PredisClient;
use Commons\Json\Encoder as JsonEncoder;
use Commons\Json\Decoder as JsonDecoder;

class RedisKeyStore extends AbstractKeyStore
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
     * @see \Commons\KeyStore\KeyStoreInterface::disconnect()
     */
    public function disconnect()
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
        $this->getPredisClient()->set($name, $this->_serialize($value));
        if (isset($ttl)) $this->getPredisClient()->expire($name, $ttl);
        return $this;
    }
    
    /**
     * Get key value.
     * @see \Commons\KeyStore\KeyStoreInterface::get()
     */
    public function get($name, $defaultValue = null)
    {
        return ($this->has($name) ? $this->_unserialize($this->getPredisClient()->get($name)) : $defaultValue);
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
    
    protected function _serialize($data)
    {
        $encoder = new JsonEncoder();
        return $encoder->encode($data);
    }
    
    protected function _unserialize($data)
    {
        $decoder = new JsonDecoder();
        return $decoder->decode($data);
    }
    
}
