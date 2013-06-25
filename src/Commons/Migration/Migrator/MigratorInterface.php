<?php

/**
 * =============================================================================
 * @file       Commons/Migration/Migrator/MigratorInterface.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Migration\Migrator;

use Commons\Migration\Versioner\VersionerInterface;

interface MigratorInterface
{
    
    /**
     * Set versioner.
     * @param VersionerInterface $versioner
     * @return MigratorInterface
     */
    public function setVersioner(VersionerInterface $versioner);
    
    /**
     * Get versioner.
     * @return VersionerInterface
     */
    public function getVersioner();
    
    /**
     * Upgrade.
     * @return MigratorInterface
     */
    public function upgrade();
    
    /**
     * Downgrade.
     * @return MigratorInterface
     */
    public function downgrade();
    
}
