<?php

/**
 * =============================================================================
 * @file       Commons/Entity/RepositoryAwareInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Entity;

interface RepositoryAwareInterface
{

    /**
     * Set repository instance.
     * @param string $class
     * @param RepositoryInterface $instance
     * @return RepositoryAwareInterface
     */
    public function setRepository($class, RepositoryInterface $instance);
    
    /**
     * Get repository instance.
     * @param string $class
     * @return RepositoryInterface
     */
    public function getRepository($class);
    
}
