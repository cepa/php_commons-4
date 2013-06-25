<?php

/**
 * =============================================================================
 * @file       Commons/Service/ServiceManagerInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Service;

interface ServiceManagerInterface
{
    
    /**
     * Get service.
     * @param string $name
     * @return object
     */
    public function getService($name);
    
}
