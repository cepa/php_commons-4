<?php

/**
 * =============================================================================
 * @file        Commons/Sql/EntityRepository.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Sql;

use Commons\Entity\Entity;
use Commons\Entity\RepositoryInterface;
use Commons\Sql\Connection\ConnectionInterface;

class EntityRepository implements RepositoryInterface
{
    
    protected $_connection;
    protected $_tableName;
    protected $_primaryKey = 'id';
    protected $_entityClass = '\\Commons\\Entity\\Entity';
    
    /**
     * Init.
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection = null)
    {
        $this->_connection = $connection;
    }
    
    /**
     * Set connection.
     * @param ConnectionInterface $connection
     * @return \Commons\Sql\EntityRepository
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->_connection = $connection;
        return $this;
    }
    
    /**
     * Get connection.
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->_connection;
    }
    
    /**
     * Set SQL table name.
     * @param string $tableName
     * @return \Commons\Sql\EntityRepository
     */
    public function setTableName($tableName)
    {
        $this->_tableName = $tableName;
        return $this;
    }
    
    /**
     * Get SQL table name.
     * @return string
     */
    public function getTableName()
    {
        return $this->_tableName;
    }
    
    /**
     * Set SQL primary key column.
     * @param string $primaryKey
     * @return \Commons\Sql\EntityRepository
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->_primaryKey = $primaryKey;
        return $this;
    }
    
    /**
     * Get SQL primary key column.
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->_primaryKey;
    }
    
    /**
     * Create new query instance assigned to this entity repository.
     * @return\Commons\Sql\Query
     */
    public function createQuery()
    {
        return $this->getConnection()
            ->createQuery()
            ->setEntityClass($this->getEntityClass())
            ->setDefaultTableName($this->getTableName());
    }
    
    /**
     * Find an entity by a key value.
     * @param string $key
     * @param mixed $value
     * @return \Commons\Entity\Entity
     */
    public function findBy($key, $value)
    {
        return $this->createQuery()
            ->select()
            ->from()
            ->where($key.' = ?', $value)
            ->limit(1)
            ->execute()
            ->fetch();
    }
    
    /**
     * 
     * @see \Commons\Entity\RepositoryInterface::setEntityClass()
     */
    public function setEntityClass($entityClass)
    {
        $this->_entityClass = $entityClass;
        return $this;
    }
    
    /**
     * 
     * @see \Commons\Entity\RepositoryInterface::getEntityClass()
     */
    public function getEntityClass()
    {
        return $this->_entityClass;
    }
    
    /**
     * 
     * @see \Commons\Entity\RepositoryInterface::fetch()
     */
    public function fetch($id)
    {
        return $this->createQuery()
            ->select()
            ->from()
            ->where($this->getPrimaryKey().' = ?', $id)
            ->execute()
            ->fetch();
    }
    
    /**
     * 
     * @see \Commons\Entity\RepositoryInterface::fetchCollection()
     */
    public function fetchCollection($criteria = null)
    {
        $query = $this->createQuery()
            ->select()
            ->from();
        
        if (isset($criteria['where'])) {
            if (is_string($criteria['where'])) {
                $query->where($criteria['where']);
            } else {
                foreach ($criteria['where'] as $key => $value) {
                    $query->addWhere($key.' = ?', $value);
                }
            }
        }
        
        if (isset($criteria['groupBy'])) {
            if (is_string($criteria['groupBy'])) {
                $query->groupBy($criteria['groupBy']);
            } else {
                foreach ($criteria['groupBy'] as $key) {
                    $query->addGroupBy($key);
                }
            }
        }
        
        if (isset($criteria['orderBy'])) {
            if (is_string($criteria['orderBy'])) {
                $query->orderBy($criteria['orderBy']);
            } else {
                foreach ($criteria['orderBy'] as $key) {
                    $query->addOrderBy($key);
                }
            }
        }
        
        if (isset($criteria['limit'])) {
            $query->limit($criteria['limit']);
        }
        
        if (isset($criteria['offset'])) {
            $query->offset($criteria['offset']);
        }
        
        return $query->execute()->fetchCollection();
    }
    
    /**
     * 
     * @see \Commons\Entity\RepositoryInterface::save()
     */
    public function save(Entity $entity)
    {
        $primaryKey = $this->getPrimaryKey();
        $isNewRecord = ($entity->has($primaryKey) ? false : true);
        $query = $this->createQuery();
        
        if ($isNewRecord) {
            $query->insert();
        } else {
            $query->update()->where($primaryKey.' = ?', $entity->get($primaryKey));
        }
        
        foreach ($entity as $key => $value) {
            $query->set($key, $value);
        }

        $query->execute();
        
        if ($isNewRecord) {
            $databaseType = $this->getConnection()->getDatabaseType();
            switch ($databaseType) {
                case Sql::TYPE_MYSQL:
                    $id = $this->getConnection()
                        ->createQuery()
                        ->select('LAST_INSERT_ID()')
                        ->execute()
                        ->fetchScalar();
                    $entity->set($primaryKey, $id);
                    break;
                    
                case Sql::TYPE_POSTGRESQL:
                    $id = $this->getConnection()
                        ->createQuery()
                        ->select("CURRVAL('{$this->getTableName()}_{$primaryKey}_seq')")
                        ->execute()
                        ->fetchScalar();
                    $entity->set($primaryKey, $id);
                    break;
            }
        }
        
        return $this;
    }
    
    /**
     * 
     * @see \Commons\Entity\RepositoryInterface::delete()
     */
    public function delete(Entity $entity)
    {
        $primaryKey = $this->getPrimaryKey();
        if (!$entity->has($primaryKey)) {
            throw new Exception("Entity does not have a primary key");
        }
        $this->createQuery()
            ->delete()
            ->where($primaryKey.' = ?', $entity->get($primaryKey))
            ->execute();
        return $this;
    }
        
}

