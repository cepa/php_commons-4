<?php

/**
 * =============================================================================
 * @file       Commons/NoSql/Mongo/Connection/AbstractConnection.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\NoSql\Mongo\Connection;

use Commons\Entity\RepositoryAwareInterface;
use Commons\Entity\RepositoryInterface;

abstract class AbstractConnection implements ConnectionInterface, RepositoryAwareInterface
{
    
    protected $_repositories = array();
    
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
