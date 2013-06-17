<?php

/**
 * =============================================================================
 * @file       Commons/Service/ServiceInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Service;

use Commons\Container\TraversableContainer;

interface ServiceInterface
{
    
    /**
     * Set service config.
     * @param TraversableContainer $config
     * @return ServiceInterface
     */
    public function setConfig(TraversableContainer $config);
    
    /**
     * Get serivce config.
     * @return TraversableContainer
     */
    public function getConfig();
    
}
