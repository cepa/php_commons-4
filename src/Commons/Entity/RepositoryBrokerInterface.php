<?php

/**
 * =============================================================================
 * @file        Commons/Entity/RepositoryBrokerInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Entity;

interface RepositoryBrokerInterface
{

    /**
     * Set repository instance.
     * @param string $repoClass
     * @param RepositoryInterface $instance
     * @return 
     */
    public function setRepository($repoClass, RepositoryInterface $instance);
    
    /**
     * Get repository instance.
     * @param string $repoClass
     * @return RepositoryInterface
     */
    public function getRepository($repoClass);
    
}

