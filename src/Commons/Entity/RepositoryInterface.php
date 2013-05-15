<?php

/**
 * =============================================================================
 * @file        Commons/Entity/RepositoryInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Entity;

interface RepositoryInterface
{
    
    /**
     * Set entity class name.
     * @param string $entityClass
     * @return RepositoryInterface
     */
    public function setEntityClass($entityClass);
    
    /**
     * Get entity class name.
     * @return string
     */
    public function getEntityClass();
    
    /**
     * Set primary key name.
     * @param string $primaryKey
     * @return RepositoryInterface
     */
    public function setPrimaryKey($primaryKey);
    
    /**
     * Get primary key name.
     * return string
     */
    public function getPrimaryKey();
    
    /**
     * Fetch entity by id.
     * @param mixed $id
     * @return Entity
     */
    public function fetch($primaryKey);
    
    /**
     * Fetch collection of entities by given criteria.
     * @param mixed $criteria
     * @return Collection
     */
    public function fetchCollection($criteria = null);
    
    /**
     * Save entity.
     * @param Entity $entity
     * @return RepositoryInterface
     */
    public function save(Entity $entity);
    
    /**
     * Delete entity.
     * @param Entity $entity
     * @return RepositoryInterface
     */
    public function delete(Entity $entity);
    
}

