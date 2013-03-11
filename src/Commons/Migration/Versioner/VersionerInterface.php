<?php

/**
 * =============================================================================
 * @file        Commons/Migration/Versioner/VersionerInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 *
 * @copyright  PHP Commons
 *              Copyright (C) 2009-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

namespace Commons\Migration\Versioner;

interface VersionerInterface 
{
    
    /**
     * Set version.
     * @param string $name
     * @param int $version
     * @return VersionerInterface
     */
    public function setVersion($name, $version);
    
    /**
     * Get version.
     * @param string $name
     * @return int
     */
    public function getVersion($name);
    
}
