<?php

/**
 * =============================================================================
 * @file       Commons/Config/ConfigAwareInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Config;

interface ConfigAwareInterface
{
    
    /**
     * Set config.
     * @param mixed $config
     * @return ConfigAwareInterface
     */
    public function setConfig($config);
    
    /**
     * Get config.
     * @return mixed
     */
    public function getConfig();
    
}
