<?php

/**
 * =============================================================================
 * @file        Commons/KeyMap/Map.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright   PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\KeyMap;

use Commons\KeyStore\KeyStoreInterface;
use Commons\Json\Encoder as JsonEncoder;
use Commons\Json\Decoder as JsonDecoder;

class Map
{
    
    protected $_keyStore;
    
    /**
     * Set keystore.
     * @param KeyStoreInterface $keyStore
     * @return \Commons\KeyMap\Map
     */
    public function setKeyStore(KeyStoreInterface $keyStore)
    {
        $this->_keyStore = $keyStore;
        return $this;
    }
    
    /**
     * Get keystore.
     * @throws Exception
     * @return KeyStoreInterface
     */
    public function getKeyStore()
    {
        if (!isset($this->_keyStore)) {
            throw new Exception("Missing key store");
        }
        return $this->_keyStore;
    }
    
    /**
     * Create new key instance.
     * @param string $unique
     * @return \Commons\KeyMap\Key
     */
    public function create($unique)
    {
        $key = new Key();
        $key
            ->setUnique($unique)
            ->setMap($this);
        return $key;
    }
    
    /**
     * Find key in keystore.
     * @param string $unique
     * @return NULL|\Commons\KeyMap\Key
     */
    public function find($unique)
    {
        if (!$this->has($unique)) {
            return null;
        }
        
        $decoder = new JsonDecoder();
        $data = $decoder->decode($this->getKeyStore()->get($unique));

        $key = $this->create($unique);
        if (isset($data['__value'])) {
            $key->setValue($data['__value']);
        }
        if (isset($data['__links'])) {
            $key->setLinks($data['__links']);
        }
        return $key;
    }
    
    /**
     * Find key or create a new one.
     * @param string $unique
     * @return \Commons\KeyMap\Key
     */
    public function findOrCreate($unique)
    {
        $key = $this->find($unique);
        return ($key ? $key : $this->create($unique)); 
    }
    
    /**
     * Check key existence in keystore.
     * @param string $unique
     * @return boolean
     */
    public function has($unique)
    {
        return $this->getKeyStore()->has($unique);
    }
    
    /**
     * Save key to keystore.
     * @param Key $key
     * @return \Commons\KeyMap\Map
     */
    public function save(Key $key)
    {
        $data = array();
        if ($key->getValue()) {
            $data['__value'] = $key->getValue();
        }
        if (count($key->getLinks()) > 0) {
            $data['__links'] = array();
            foreach ($key->getLinks() as $unique) {
                $data['__links'][] = $unique;
            }
        }
        $encoder = new JsonEncoder();
        $this->getKeyStore()->set($key->getUnique(), $encoder->encode($data));
        return $this;
    }
    
    /**
     * Cascade delete of key and all linked remote keys.
     * @param Key $key
     * @return \Commons\KeyMap\Map
     */
    public function delete(Key $key)
    {
        foreach ($key->getLinks() as $unique) {
            $key->removeLink($unique);
            $leaf = $this->find($unique);
            if ($leaf instanceof Key) {
                $this->delete($leaf);
            }
        }
        $this->getKeyStore()->remove($key->getUnique());
        return $this;
    }
    
}
