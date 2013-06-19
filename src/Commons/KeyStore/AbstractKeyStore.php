<?php

/**
 * =============================================================================
 * @file       Commons/KeyStore/AbstractKeyStore.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\KeyStore;

use Commons\Entity\RepositoryAwareInterface;
use Commons\Entity\RepositoryInterface;

abstract class AbstractKeyStore implements KeyStoreInterface, RepositoryAwareInterface
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
