<?php

/**
 * =============================================================================
 * @file        Commons/KeyStore/EntityRepository.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright   PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\KeyStore;

use Commons\Entity\Entity;
use Commons\Entity\AbstractRepository;
use Commons\Json\Encoder as JsonEncoder;
use Commons\Json\Decoder as JsonDecoder;

class EntityRepository extends AbstractRepository
{
    
    protected $_keyStore;
    
    /**
     * Set key store.
     * @param KeyStoreInterface $keyStore
     * @return \Commons\KeyStore\EntityRepository
     */
    public function setKeyStore(KeyStoreInterface $keyStore)
    {
        $this->_keyStore = $keyStore;
        return $this;
    }
    
    /**
     * Get key store.
     * @return KeyStoreInterface
     */
    public function getKeyStore()
    {
        return $this->_keyStore;
    }
    
    /**
     * Fetch entity from key store.
     * @see \Commons\Entity\RepositoryInterface::fetch()
     */
    public function fetch($primaryKey)
    {
        if (!$this->getKeyStore()->has($primaryKey)) {
            return null;
        }
        $decoder = new JsonDecoder();
        $array = $decoder->decode($this->getKeyStore()->get($primaryKey));
        $entityClass = $this->getEntityClass();
        return new $entityClass($array);
    }
    
    /**
     * Not supported by default.
     * @see \Commons\Entity\RepositoryInterface::fetchCollection()
     */
    public function fetchCollection($criteria = null)
    {
        throw new Exception("Not supported");    
    }
    
    /**
     * Save entity to key store.
     * @see \Commons\Entity\RepositoryInterface::save()
     */
    public function save(Entity $entity)
    {
        $encoder = new JsonEncoder();
        $json = $encoder->encode($entity->toArray());
        $this->getKeyStore()->set($entity->get($this->getPrimaryKey()), $json);
        return $this;
    }
    
    /**
     * Delete entity from key store.
     * @see \Commons\Entity\RepositoryInterface::delete()
     */
    public function delete(Entity $entity)
    {
        $this->getKeyStore()->remove($entity->get($this->getPrimaryKey()));
        return $this;
    }
    
}
