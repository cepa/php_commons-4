<?php

/**
 * =============================================================================
 * @file       Commons/NoSql/Mongo/EntityRepository.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\NoSql\Mongo;

use MongoDB;
use Commons\Entity\AbstractRepository;
use Commons\Entity\Collection;
use Commons\Entity\Entity;

class EntityRepository extends AbstractRepository
{
    
    protected $_mongoDb;
    protected $_collectionName;
    
    public function __construct(MongoDB $db = null)
    {
        $this->_mongoDb = $db;
    }

    public function setMongoDb(MongoDB $db)
    {
        $this->_mongoDb = $db;
        return $this;
    }
    
    public function getMongoDb()
    {
        return $this->_mongoDb;
    }
    
    public function setCollectionName($collectionName)
    {
        $this->_collectionName = (string) $collectionName;
        return $this;
    }
    
    public function getCollectionName()
    {
        return $this->_collectionName;
    }
    
    public function fetch($primaryKey)
    {
        $item = $this->getMongoDb()
            ->selectCollection($this->getCollectionName())
            ->findOne(array('_id' => $primaryKey));
        if (!$item) {
            return null;
        }
        unset($item['_id']);
        $entityClass = $this->getEntityClass();
        return new $entityClass($item);
    }
    
    public function fetchCollection($criteria = null)
    {
        throw new Exception("Not implemented");
    }
    
    public function save(Entity $entity)
    {
        $this->getMongoDb()
            ->selectCollection($this->getCollectionName())
            ->save(array_merge(array('_id' => $entity->get($this->getPrimaryKey())), $entity->toArray()));
        return $this;
    }
    
    public function delete(Entity $entity)
    {
        $this->getMongoDb()
            ->selectCollection($this->getCollectionName())
            ->remove(array('_id' => $entity->get($this->getPrimaryKey())));
        return $this;
    }
    
} 
