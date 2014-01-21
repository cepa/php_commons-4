<?php

/**
 * =============================================================================
 * @file       Commons/Sql/EntityRepository.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Sql;

use Commons\Entity\Entity;
use Commons\Entity\AbstractRepository;
use Commons\Sql\Connection\ConnectionInterface;

class EntityRepository extends AbstractRepository
{

    protected $_connection;
    protected $_tableName;

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
     * @see \Commons\Entity\RepositoryInterface::fetch()
     */
    public function fetch($primaryKey)
    {
        $pKeys = (is_array($this->getPrimaryKey()) ? $this->getPrimaryKey() : array($this->getPrimaryKey()));
        $pVals = (is_array($primaryKey) ? $primaryKey : array($primaryKey));
        if (count($pKeys) != count($pVals)) {
            throw new Exception("Invalid composite primary key");
        }
        $query = $this->createQuery()->select()->from();
        for ($i = 0, $n = count($pKeys); $i < $n; $i++) {
            $query->addWhere($pKeys[$i].' = ?', $pVals[$i]);
        }
        return $query->execute()->fetch();
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
        return (is_array($this->getPrimaryKey())
            ? $this->_saveByCompositePrimaryKey($entity)
            : $this->_saveBySinglePrimaryKey($entity));
    }

    protected function _saveByCompositePrimaryKey(Entity $entity)
    {
        $query = $this->createQuery()->select('COUNT(*)')->from();
        $pKeys = $this->getPrimaryKey();
        foreach ($pKeys as $pKey) {
            $query->addWhere($pKey . ' = ?', $entity->get($pKey));
        }
        $count = $query->execute()->fetchScalar();

        if ($count == 0) {
            $query = $this->createQuery()->insert();

        } else {
            $query = $this->createQuery()->update();
            foreach ($pKeys as $pKey) {
            if (!$entity->has($pKey)) {
                throw new Exception("Missing value for composite key: " . $pKey);
            }
            $query->addWhere($pKey . ' = ?', $entity->get($pKey));
            }
        }

        foreach ($entity as $key => $value) {
            $query->set($key, $value);
        }

        $query->execute();

        return $this;
    }

    protected function _saveBySinglePrimaryKey(Entity $entity)
    {
        $primaryKey = $this->getPrimaryKey();
        $query = $this->createQuery();

        if ($entity->has($primaryKey)) {
            $pk = $this->createQuery()
                ->select($this->getPrimaryKey())
                ->from()
                ->where($this->getPrimaryKey().' = ?', $entity->get($primaryKey))
                ->execute()
                ->fetchScalar();
            if ($pk == $entity->get($primaryKey)) {
                $query->update()->where($primaryKey.' = ?', $entity->get($primaryKey));
            } else {
                $query->insert();
            }
        } else {
            $query->insert();
        }

        foreach ($entity as $key => $value) {
            $query->set($key, $value);
        }

        $query->execute();

        if (!$entity->has($primaryKey)) {
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
        $pKeys = (is_array($this->getPrimaryKey()) ? $this->getPrimaryKey() : array($this->getPrimaryKey()));
        foreach ($pKeys as $pKey) {
            if (!$entity->has($pKey)) {
                throw new Exception("Entity does not have a primary key: " . $pKey);
            }
        }
        $query = $this->createQuery()->delete();
        foreach ($pKeys as $pKey) {
            $query->addWhere($pKey . ' = ?', $entity->get($pKey));
        }
        $query->execute();
        return $this;
    }

}

