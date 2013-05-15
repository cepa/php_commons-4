<?php

/**
 * =============================================================================
 * @file        Commons/Entity/AbstractRepository.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Entity;

abstract class AbstractRepository implements RepositoryInterface
{
    
    protected $_entityClass = '\Commons\Entity\Entity';
    protected $_primaryKey = 'id';

    /**
     * Set entity class name.
     * @see \Commons\Entity\RepositoryInterface::setEntityClass()
     */
    public function setEntityClass($entityClass)
    {
        $this->_entityClass = $entityClass;
        return $this;
    }
    
    /**
     * Get entity class name.
     * @see \Commons\Entity\RepositoryInterface::getEntityClass()
     */
    public function getEntityClass()
    {
        return $this->_entityClass;
    }

    /**
     * Set primary key name.
     * @see \Commons\Entity\RepositoryInterface::setPrimaryKey()
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->_primaryKey = $primaryKey;
        return $this;
    }

    /**
     * Get primary key name.
     * @see \Commons\Entity\RepositoryInterface::getPrimaryKey()
     */
    public function getPrimaryKey()
    {
        return $this->_primaryKey;
    }
    
}
