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

use Commons\Entity\AbstractRepository;
use Commons\Entity\Collection;
use Commons\Entity\Entity;
use Commons\NoSql\Mongo\Connection\ConnectionInterface;

class EntityRepository extends AbstractRepository
{
    
    protected $_connection;
    protected $_collectionName;

    public function __construct(ConnectionInterface $connection = null)
    {
        $this->_connection = $connection;
    }
    
    public function setConnection(ConnectionInterface $connection)
    {
        $this->_connection = $connection;
        return $this;
    }
    
    public function getConnection()
    {
        return $this->_connection;
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
        $item = $this->getConnection()
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
        $this->getConnection()
            ->selectCollection($this->getCollectionName())
            ->save(array_merge(array('_id' => $entity->get($this->getPrimaryKey())), $entity->toArray()));
        return $this;
    }
    
    public function delete(Entity $entity)
    {
        $this->getConnection()
            ->selectCollection($this->getCollectionName())
            ->remove(array('_id' => $entity->get($this->getPrimaryKey())));
        return $this;
    }
    
} 
