<?php

/**
 * =============================================================================
 * @file       Commons/Sql/Connection/AbstractConnection.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Sql\Connection;

use Commons\Entity\RepositoryAwareInterface;
use Commons\Entity\RepositoryInterface;
use Commons\Sql\Query;

abstract class AbstractConnection implements ConnectionInterface, RepositoryAwareInterface
{
    
    protected $_repositories = array();

    /**
     * Create a new query.
     * @return Query
     */
    public function createQuery()
    {
        return new Query($this);
    }
    
    /**
     * Set repository instance.
     * @param string $repoClass
     * @param RepositoryInterface $instance
     */
    public function setRepository($repoClass, RepositoryInterface $instance)
    {
        $this->_repositories[$repoClass] = $instance;
        return $this;
    }
    
    /**
     * Get repository instance.
     * @param string $repoClass
     * @return RepositoryInterface
     */
    public function getRepository($repoClass)
    {
        if (!isset($this->_repositories[$repoClass])) {
            $this->setRepository($repoClass, new $repoClass($this));
        }
        return $this->_repositories[$repoClass];
    }
        
}
