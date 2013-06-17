<?php

/**
 * =============================================================================
 * @file       Commons/Config/Adapter/AdapterInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Config\Adapter;

use Commons\Config\Config;

interface AdapterInterface
{

    /**
     * Set config.
     * @param Config $config
     * @return AdapterInterface
     */
    public function setConfig(Config $config);
    
    /**
     * Get config.
     * @return Config
     */
    public function getConfig();
    
    /**
     * Load config from loadable.
     * @param mixed $loadable
     * @return AdapterInterface
     */
    public function load($loadable);
    
    /**
     * Load config from file.
     * @param mixed $filename
     * @return AdapterInterface
     */
    public function loadFromFile($filename);
    
}
