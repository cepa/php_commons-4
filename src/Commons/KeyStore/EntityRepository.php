<?php

/**
 * =============================================================================
 * @file       Commons/KeyStore/EntityRepository.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\KeyStore;

use Commons\Entity\Entity;
use Commons\Entity\AbstractRepository;

class EntityRepository extends AbstractRepository
{
    
    protected $_keyStore;
    
    public function __construct(KeyStoreInterface $keyStore = null)
    {
        $this->_keyStore = $keyStore;
    }
    
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
        $array = $this->getKeyStore()->get($primaryKey);
        if (!is_array($array)) {
            throw new Exception("Invalid value for key {$primaryKey}");
        }
        $entityClass = $this->getEntityClass();
        return new $entityClass($array);
    }
    
    /**
     * Not supported by default.
     * @see \Commons\Entity\RepositoryInterface::fetchCollection()
     */
    public function fetchCollection($criteria = null)
    {
        throw new Exception("Not implemented");    
    }
    
    /**
     * Save entity to key store.
     * @see \Commons\Entity\RepositoryInterface::save()
     */
    public function save(Entity $entity)
    {
        $this->getKeyStore()->set($entity->get($this->getPrimaryKey()), $entity->toArray());
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
